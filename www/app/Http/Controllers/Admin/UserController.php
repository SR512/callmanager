<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SmSConfigurationRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Mail\UserCreateNotification;
use App\Models\Categories;
use App\Models\City;
use App\Models\Language;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [];
        $params['query_str'] = $request->query_str;
        $params['role'] = $request->role;
        $params['page'] = $request->page ?? 0;

        if (!empty($request->start_date) && !empty($request->start_date)) {
            $params['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
            $params['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d 23:59:00');
        } else {
            $params['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
            $params['end_date'] = Carbon::now()->format('Y-m-d 23:59:00');
        }

        $table = resolve('user-repo')->renderHtmlTable($params);

        $skip_roles = [config('constants.SUPER_ADMIN')];
        $roles = Role::whereNotIn('name', $skip_roles)->pluck('name', 'id');
        return view('admin.usermanagement.user_list', compact('table', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [];
        try {
            $skip_roles = [config('constants.SUPER_ADMIN')];
            $roles = Role::whereNotIn('name', $skip_roles)->pluck('name', 'id');

            $data['error'] = false;
            $data['view'] = view('admin.usermanagement.offcanvas', compact('roles'))->render();
            return response()->json($data);

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function setSMSConfiguration($id)
    {
        $data = [];
        try {
            $user = resolve('user-repo')->findByID($id);
            $data['error'] = false;
            $data['view'] = view('admin.usermanagement.sms_configuration_offcanvas', compact('user'))->render();
            return response()->json($data);

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function storeSMSConfiguration(SmSConfigurationRequest $request)
    {
        $data = $params = [];
        DB::beginTransaction();
        try {
            $params['user_id'] = $request->user_id;
            $params['api_key'] = $request->api_key;
            $params['username'] = $request->username;
            $params['sender_name'] = $request->sender_name;
            $params['sms_type'] = $request->sms_type;

            $smsconfiguration = resolve('smsconfiguration-repo')->create($params);

            if (!empty($smsconfiguration)) {

                $params = [];
                $params['page'] = $request->page ?? 0;

                if (!empty($request->start_date) && !empty($request->start_date)) {
                    $params['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d 23:59:00');
                } else {
                    $params['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::now()->format('Y-m-d 23:59:00');
                }

                $data['error'] = false;
                $data['message'] = 'Sms configuration updated successfully.';
                $data['view'] = resolve('user-repo')->renderHtmlTable($params);

                DB::commit();
                return response()->json($data);

            }

            $data['error'] = true;
            $data['message'] = 'Sms configuration not updated.';
            return response()->json($data);

        } catch (\Exception $e) {
            DB::rollBack();
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $params = [];
        DB::beginTransaction();
        try {

            $password = Str::random($length = 8);
            // Create user
            $params['role'] = $request->role;
            $params['name'] = $request->name;
            $params['email'] = $request->email;
            $params['password'] = Hash::make($password);
            $params['expiry_date'] = $request->expiry_date;
            $params['remember_token'] = Str::random(10);
            $params['message'] = $request->message;
            $params['device'] = $request->device;

            $isUserExists = User::where('email', $request->email)->exists();

            if (!empty($isUserExists)) {
                $data['error'] = true;
                $data['message'] = 'User already created..!';
                return response()->json($data);
            }

            $user = resolve('user-repo')->create($params);

            if (!empty($user)) {

                // Send Mail Username and Password
                $params = [];
                $params['user'] = $user->name;
                $params['email'] = $request->email;
                $params['password'] = $password;
                $params['role_name'] = $user->getRoleNames()->first();

                Mail::send(new UserCreateNotification($params));

                $params = [];
                $params['page'] = $request->page ?? 0;
                if (!empty($request->start_date) && !empty($request->start_date)) {
                    $params['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d 23:59:00');
                } else {
                    $params['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::now()->format('Y-m-d 23:59:00');
                }
                $data['error'] = false;
                $data['message'] = 'User create successfully.';
                $data['view'] = resolve('user-repo')->renderHtmlTable($params);

                DB::commit();
                return response()->json($data);

            }

            $data['error'] = true;
            $data['message'] = 'User not created successfully..!';
            return response()->json($data);

        } catch (\Exception $e) {
            DB::rollBack();
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        try {
            $user = resolve('user-repo')->findByID($id);
            $skip_roles = [config('constants.SUPER_ADMIN')];
            $roles = Role::whereNotIn('name', $skip_roles)->pluck('name', 'id');

            $data['error'] = false;
            $data['view'] = view('admin.usermanagement.offcanvas', compact('roles', 'user'))->render();
            return response()->json($data);

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $params = [];
        DB::beginTransaction();
        try {

            // Update user
            $params = [];
            $params['role'] = $request->role;
            $params['name'] = $request->name;
            $params['email'] = $request->email;
            $params['expiry_date'] = $request->expiry_date;
            $params['message'] = $request->message;
            $params['device'] = $request->device;

            $user = resolve('user-repo')->update($params, $id);

            if (!empty($user)) {

                $params = [];
                $params['page'] = $request->page ?? 0;
                if (!empty($request->start_date) && !empty($request->start_date)) {
                    $params['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d 23:59:00');
                } else {
                    $params['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
                    $params['end_date'] = Carbon::now()->format('Y-m-d 23:59:00');
                }
                $data['error'] = false;
                $data['message'] = 'User update successfully.';
                $data['view'] = resolve('user-repo')->renderHtmlTable($params);

                DB::commit();
                return response()->json($data);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = resolve('user-repo')->findById($id);
            if (!empty($user)) {
                $user->devices()->delete();
                $user->delete();
                DB::commit();
                toastr()->success($user->name . ' deleted successfully..!');
                return redirect()->route('usermanagement.index');
            } else {
                toastr()->error('User not found.!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function changeStatus($id)
    {
        try {
            $user = resolve('user-repo')->changeStatus($id);
            toastr()->success('Status changed successfully..!');
            return redirect()->route('usermanagement.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    // Change Password

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $params = [];
            $params['password'] = Hash::make($request->password);
            $user = resolve('user-repo')->changePassword($params, auth()->user()->id);
            if ($user) {
                toastr()->success('Password changed successfully..!');
            } else {
                toastr()->error('Password not changed successfully..!');

            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }
        return redirect()->back();
    }
}

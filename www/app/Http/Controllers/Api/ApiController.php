<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $data = [];
        try {

            $user_data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (auth()->attempt($user_data)) {

                if (!$this->isUserActive()) {

                    auth()->logout();

                    $data['error'] = true;
                    $data['message'] = "Your account is inactive.";
                    return response()->json($data, 200);

                }

                if ($this->isAccountExpired()) {

                    auth()->logout();
                    $data['error'] = true;
                    $data['message'] = "Your account is expired.";
                    return response()->json($data, 200);

                }

                $data['error'] = false;
                $data['token'] = auth()->user()->createToken('callmanager')->accessToken;
                $data['user'] = [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'message' => auth()->user()->message,
                    'expiry_date' => auth()->user()->expiry_date_at_formatted,
                    'day_left' => Carbon::now()->diffInDays(auth()->user()->expiry_date . " 00:00:00"),
                ];

                return response()->json($data, 200);

            } else {
                $data['error'] = true;
                $data['message'] = "Unauthorised";
                return response()->json($data, 200);
            }

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }

    }

    public function deviceInfo(Request $request)
    {
        $data = [];
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'device_code' => 'required',
            ]);

            if ($validator->fails()) {

                $data['error'] = true;
                $data['message'] = "Field required..!";
                $data['errors'] = $validator->errors();

                return response()->json($data, 401);
            }

            if (!auth()->check()) {
                $data['error'] = true;
                $data['message'] = "Login again..!";
                return response()->json($data, 200);
            }

            if (!$this->isUserActive()) {

                auth()->user()->token()->revoke();

                $data['error'] = true;
                $data['message'] = "Your account is inactive.";
                return response()->json($data, 200);

            }

            if ($this->isAccountExpired()) {

                auth()->user()->token()->revoke();

                $data['error'] = true;
                $data['message'] = "Your account is expired.";
                return response()->json($data, 200);

            }

            $device = Devices::where('device_code', $request->device_code)->where('user_id', $request->user_id)->first();

            if (empty($device)) {
                $data['error'] = true;
                $data['message'] = "Device not register..!";
                return response()->json($data, 200);
            } else {

                $data['error'] = false;
                $data['message'] = "Get device successfully..!";
                $data['data'] = [
                    'id' => $device->id,
                    'device_code' => $device->device_code,
                    'device_os' => $device->device_os,
                    'device_model' => $device->device_model,
                    'is_active' => $device->is_active,
                ];

                return response()->json($data, 200);
            }

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }

    public function registerDevice(Request $request)
    {
        $data = [];
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'device_code' => 'required',
                'device_os' => 'required',
                'device_model' => 'required',
                'is_active' => 'required',
            ]);

            if ($validator->fails()) {

                $data['error'] = true;
                $data['message'] = "Field required..!";
                $data['errors'] = $validator->errors();

                return response()->json($data, 401);
            }

            if (!auth()->check()) {
                $data['error'] = true;
                $data['message'] = "Login again..!";
                return response()->json($data, 200);
            }

            if (auth()->user()->devices()->count() >= auth()->user()->device) {
                $data['error'] = true;
                $data['message'] = "You have reached a maximum device limit.";
                return response()->json($data, 200);
            }

            $is_device_exists = Devices::where('device_code', $request->device_code)->first();

            if (!empty($is_device_exists)) {
                $data['error'] = true;
                $data['message'] = "Device already register..!";
                return response()->json($data, 200);
            }

            $device = resolve('device-repo')->create($request->toArray());

            if (!empty($device)) {
                $data['error'] = false;
                $data['message'] = "Device register successfully..!";
                $data['data'] = [
                    'id' => $device->id,
                    'device_code' => $device->device_code,
                    'device_os' => $device->device_os,
                    'device_model' => $device->device_model,
                    'is_active' => $device->is_active,
                ];
                return response()->json($data, 200);
            } else {
                $data['error'] = true;
                $data['message'] = "Device not register..!";
                return response()->json($data, 200);
            }

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }

    public function sendMessage(Request $request)
    {
        $data = [];
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'device_id' => 'required',
                'message' => 'required',
                'number' => 'required|numeric',
            ]);

            if ($validator->fails()) {

                $data['error'] = true;
                $data['message'] = "Field required..!";
                $data['errors'] = $validator->errors();

                return response()->json($data, 401);
            }

            if (!auth()->check()) {
                $data['error'] = true;
                $data['message'] = "Login again..!";
                return response()->json($data, 200);
            }

            if (!$this->isUserActive()) {

                auth()->user()->token()->revoke();

                $data['error'] = true;
                $data['message'] = "Your account is inactive.";
                return response()->json($data, 200);

            }

            if ($this->isAccountExpired()) {

                auth()->user()->token()->revoke();

                $data['error'] = true;
                $data['message'] = "Your account is expired.";
                return response()->json($data, 200);

            }

            if (auth()->user()->message <= 0) {

                $data['error'] = true;
                $data['message'] = "Insufficient balance.";
                return response()->json($data, 200);

            }

            $is_user_link_device = Devices::where('id', $request->device_id)->where('user_id', $request->user_id)->first();

            if (empty($is_user_link_device)) {
                $data['error'] = true;
                $data['message'] = "This user not register with device..!";
                return response()->json($data, 200);
            }

            $params = [];
            $params['user_id'] = $request->user_id;
            $params['device_id'] = $request->device_id;
            $params['message'] = $request->message;
            $params['date'] = Carbon::now()->format('Y-m-d');


            $username = auth()->user()->sms_configuration->username;
            $sender_name = auth()->user()->sms_configuration->sender_name;
            $sms_type = auth()->user()->sms_configuration->sms_type;
            $api_key = auth()->user()->sms_configuration->api_key;

            if (empty($username) || empty($sender_name) || empty($sms_type) || empty($api_key)) {
                $data['error'] = true;
                $data['message'] = "Please configure you sms api gatway.";
                return response()->json($data, 200);
            }

            $url = config('constants.SMS_API_URL') . "/sendSMS?username=" . $username . "&message=" . $request->message . "&sendername=" . $sender_name . "&smstype=" . $sms_type . "&numbers=" . $request->number . "&apikey=" . $api_key;

            $response = Http::get($url);

            if ($response->status() == 200) {

                $decodeResponse = json_decode($response->body(), true);

                if ($decodeResponse[0]['responseCode'] == 'Message SuccessFully Submitted') {
                    $params['is_send'] = 'Y';

                    $smslog = resolve('sms-log-repo')->create($params);

                    $user = User::where('id', $request->user_id)->first();
                    $user->message = $user->message - 1;
                    $user->save();

                    $data['error'] = false;
                    $data['message'] = "Message SuccessFully Submitted";
                    return response()->json($data, 200);

                } else {
                    $params['errors'] = $decodeResponse[0]['responseCode'];
                    $params['is_send'] = 'N';

                    $smslog = resolve('sms-log-repo')->create($params);

                    $data['error'] = true;
                    $data['message'] = "Message not Submitted";
                    return response()->json($data, 200);
                }
            } else {
                $data['error'] = false;
                $data['message'] = "Try again..!";
                return response()->json($data, 200);
            }

        } catch (\Exception $e) {
            $data['error'] = true;
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }

    }

    public function isUserActive()
    {
        if (auth()->user()->is_active != 'Y') {
            return false;
        }
        return true;
    }

    public function isAccountExpired()
    {
        if (auth()->user()->expiry_date <= Carbon::now()->format('Y-m-d')) {
            return true;
        }
        return false;
    }
}

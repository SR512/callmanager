<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SmsLogExport;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SmsLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SmsLogsController extends Controller
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
        $params['page'] = $request->page ?? 0;
        $params['status'] = $request->status;

        if (!empty($request->start_date) && !empty($request->start_date)) {
            $params['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
            $params['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d 23:59:00');
        } else {
            $params['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d 00:00:00');
            $params['end_date'] = Carbon::now()->format('Y-m-d 23:59:00');
        }

        if (isset($request->type) && $request->type != 'submit') {
            return Excel::download(new SmsLogExport($params), time() . '_sms_report.xlsx');
        }
        $table = resolve('sms-log-repo')->renderHtmlTable($params);
        return view('admin.smslog.smslog_list', compact('table'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

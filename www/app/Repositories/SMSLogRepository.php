<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\SmsLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SMSLogRepository
{
    public $model;

    /**
     * UserRepository constructor.
     */
    public function __construct(SmsLogs $model)
    {
        return $this->model = $model;
    }

    // Get data by id
    public function findByID($id)
    {
        return $this->model->findorFail($id);
    }

    // Create new recoard
    public function create($params)
    {
        return $this->model->create($params);;
    }

    // Update recoard
    public function update($params, $id)
    {
        return $this->findByID($id)->update($params);;
    }

    public function filter($params)
    {

        $this->model = $this->model->when(!empty($params['query_str']), function ($query) use ($params) {
            $query->whereHas('users',function ($query) use ($params){
                $query->where('name', 'LIKE', '%' . $params['query_str'] . "%");
            });
        });

        $this->model = $this->model->when(!empty($params['status']), function ($query) use ($params) {
            $query->where('is_send', $params['status']);
        });

        $this->model = $this->model->when(!empty($params['start_date'] && !empty($params['end_date'])), function ($q) use ($params) {
            return $q->whereBetween('date', [$params['start_date'], $params['end_date']]);
        });

        if(auth()->user()->getRole() ==  config('constants.USER')){
            $this->model = $this->model->where('user_id',auth()->id());

        }

        return $this->model->latest()->paginate(config('constants.PER_PAGE'), ['*'],'page',!empty($params['page'])? $params['page']:'');

    }

    public function renderHtmlTable($params)
    {
        $tableData = $this->filter($params);
        return view('admin.smslog.table', compact('tableData'))->render();
    }

}

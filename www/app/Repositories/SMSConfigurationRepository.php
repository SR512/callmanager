<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\Devices;
use App\Models\SmsConfiguration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SMSConfigurationRepository
{
    public $model;

    /**
     * UserRepository constructor.
     */
    public function __construct(SmsConfiguration $model)
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

        return $this->model->updateOrCreate(['user_id' => $params['user_id']],$params);
    }

    // Update recoard
    public function update($params, $id)
    {
        $device = $this->findByID($id)->update($params);

        return $device;
    }


    public function filter($params)
    {

        return $this->model->latest();

    }

}

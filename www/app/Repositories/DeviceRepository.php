<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\Devices;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeviceRepository
{
    public $model;

    /**
     * UserRepository constructor.
     */
    public function __construct(Devices $model)
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

        return $this->model->create($params);
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

    public function changeStatus($id)
    {
        $device = $this->findByID($id);
        if ($device->is_active == 'Y') {
            $device->is_active = 'N';
        } else {
            $device->is_active = 'Y';
        }

        return $device->save();
    }

}

<?php

namespace App\Models;

use App\Traits\CustomTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory, CustomTimestamps;

    protected $table = "devices";
    protected $fillable = [
        'user_id',
        'device_code',
        'device_os',
        'device_model',
        'is_active',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];
}

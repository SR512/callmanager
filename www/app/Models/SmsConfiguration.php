<?php

namespace App\Models;

use App\Traits\CustomTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsConfiguration extends Model
{
    use HasFactory,CustomTimestamps;

    protected $table="sms_configuration";
    protected $fillable = [
        'user_id',
        'api_key',
        'username',
        'sender_name',
        'sms_type',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];
}

<?php

namespace App\Models;

use App\Traits\CustomTimestamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLogs extends Model
{
    use HasFactory, CustomTimestamps;

    protected $table = "sms_logs";
    protected $fillable = [
        'user_id',
        'device_id',
        'date',
        'message',
        'errors',
        'is_send',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    public function devices()
    {
        return $this->belongsTo(Devices::class, 'device_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDateFormattedAttribute()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }
}

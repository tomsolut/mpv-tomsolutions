<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'device_type_id',
        'name',
        'recall_period',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }

    /**
     * Get all doctor devices for this device.
     */
    public function doctorDevices()
    {
        return $this->hasMany(DoctorDevice::class);
    }

    /**
     * Get the next recall date based on recall period.
     */
    public function getNextRecallDateAttribute()
    {
        return now()->addDays($this->recall_period);
    }
}

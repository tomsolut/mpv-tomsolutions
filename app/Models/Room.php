<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'location_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get all doctor devices in this room.
     */
    public function doctorDevices()
    {
        return $this->hasMany(DoctorDevice::class);
    }

    /**
     * Get the count of devices in this room.
     */
    public function getDevicesCountAttribute()
    {
        return $this->doctorDevices()->count();
    }

    /**
     * Get overdue devices in this room.
     */
    public function getOverdueDevicesAttribute()
    {
        return $this->doctorDevices()->get()->filter(function ($device) {
            return $device->getIsOverdueAttribute();
        });
    }
}

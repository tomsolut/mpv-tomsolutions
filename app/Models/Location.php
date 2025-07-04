<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'city',
        'postal_code',
        'street1',
        'street2',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all rooms in this location.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get full address as string.
     */
    public function getFullAddressAttribute()
    {
        $address = trim($this->street1);
        if ($this->street2) {
            $address .= ', ' . trim($this->street2);
        }
        $address .= ', ' . $this->postal_code . ' ' . $this->city;
        
        return $address;
    }

    /**
     * Get total count of devices in this location.
     */
    public function getTotalDevicesCountAttribute()
    {
        return $this->rooms()->withCount('doctorDevices')->get()->sum('doctor_devices_count');
    }

    /**
     * Get all overdue devices in this location.
     */
    public function getOverdueDevicesAttribute()
    {
        $overdueDevices = collect();
        foreach ($this->rooms as $room) {
            $overdueDevices = $overdueDevices->merge($room->getOverdueDevicesAttribute());
        }
        return $overdueDevices;
    }
}

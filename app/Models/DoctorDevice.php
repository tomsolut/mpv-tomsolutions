<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorDevice extends Model
{
    protected $fillable = [
        'device_id',
        'room_id',
        'name',
        'serial_number',
        'last_certification_date',
    ];

    protected $casts = [
        'last_certification_date' => 'date',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

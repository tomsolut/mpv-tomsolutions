<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'doctor_device_id',
        'name',
        'file',
    ];

    public function doctorDevice()
    {
        return $this->belongsTo(DoctorDevice::class);
    }
}

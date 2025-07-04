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
        'notes',
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

    /**
     * Get all attachments for this doctor device.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Get the next certification date based on device recall period.
     */
    public function getNextCertificationDateAttribute()
    {
        if (!$this->last_certification_date || !$this->device) {
            return null;
        }

        return $this->last_certification_date->addDays($this->device->recall_period);
    }

    /**
     * Check if certification is overdue.
     */
    public function getIsOverdueAttribute()
    {
        $nextDate = $this->getNextCertificationDateAttribute();
        return $nextDate && $nextDate->isPast();
    }
}

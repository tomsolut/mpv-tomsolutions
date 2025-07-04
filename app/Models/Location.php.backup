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
}

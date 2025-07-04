<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'city',
        'country',
        'postal_code',
        'street1',
        'street2',
    ];
}

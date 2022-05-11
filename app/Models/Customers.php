<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'city',
        'state',
        'phone',
        'contact_person',
        'gtin_start',
        'gtin_end',
    ];
}

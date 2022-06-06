<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'plu',
        'product_name',
        'qty',
    ];
}

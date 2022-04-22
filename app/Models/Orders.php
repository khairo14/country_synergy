<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_type',
        'dispatch',
    ];

    public function products(){
        return $this->hasMany('App\Models\Rel_order_products','order_id');
    }
}

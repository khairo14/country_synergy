<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rel_order_products extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
    ];

    public function orders(){
        return $this->belongsTo('App\Models\Orders','order_id');
    }
    public function products(){
        return $this->belongsTo('App\Models\Products','product_id');
    }

}

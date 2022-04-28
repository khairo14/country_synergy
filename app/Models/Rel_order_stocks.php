<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rel_order_stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'stock_id',
        'customer_id',
    ];

    public function order(){
        return $this->belongsTo('App\Models\Orders');
    }

    public function stock(){
        return $this->belongsTo('App\Models\Stocks');
    }
}

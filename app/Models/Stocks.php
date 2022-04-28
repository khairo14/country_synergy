<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_label',
    ];

    public function stocks(){
        return $this->hasMany('App\Models\Rel_order_stocks','stock_id');
    }
}

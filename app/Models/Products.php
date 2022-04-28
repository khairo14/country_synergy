<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'gtin',
        'product_name',
        'company_id',
        'brand',
        'size',
        'description',
    ];

    public function products(){
        return $this->belongsTo('App\Models\Rel_order_products','product_id');
    }
}

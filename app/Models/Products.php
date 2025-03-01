<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'gtin',
        'brand',
        'size',
        'description',
        'company_id',
    ];
}

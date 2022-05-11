<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'scanned_id',
        'gtin',
        'old_pallet_id',
        'new_pallet_id',
        'actions',
    ];
}

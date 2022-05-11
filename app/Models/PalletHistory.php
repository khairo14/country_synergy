<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_pallet_id',
        'new_pallet_id',
        'item_quantity',
        'actions',
        'old_locations',
        'new_locations',
    ];
}

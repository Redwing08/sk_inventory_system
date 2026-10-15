<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Define the database table name (optional, Laravel auto-detects 'inventories')
    protected $table = 'inventories';

    // Mass fillable attributes for safety
    protected $fillable = [
        'item_code',
        'item_name',
        'category',
        'quantity',
        'unit',
        'unit_price',
        'status',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'type', 'amount', 'current_stock'
    ];

    public static function boot() {

        parent::boot();
        
    }
}

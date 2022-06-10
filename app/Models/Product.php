<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'stock_tracked', 'image', 'tax_id', 'tax_type', 'type'
    ];

    public function prices()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }

    public function sellPrice()
    {
        return $this->prices() ? $this->prices()->where('type','sell')->latest()->first()->price ?? 0 : 0;
    }

    public function buyPrice()
    {
        return $this->prices() ? $this->prices()->where('type','buy')->latest()->first()->price ?? 0 : 0;
    }

    public function stockHistories()
    {   
        return $this->hasMany(ProductStockHistory::class);
    }

    public function current_stock()
    {
        return $this->stockHistories() ? $this->stockHistories()->latest()->first()->current_stock ?? 0 : 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}

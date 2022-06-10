<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id','product_id','amount','price','discount','total','tax'
    ];

    public static function boot() 
    {
        parent::boot();
        static::created(function($model) {

            // adjust product stock
            if($model->product->stock_tracked) {
                $latestStock = $model->product->current_stock();
                $newStock = $latestStock - $model->amount;

                ProductStockHistory::create([
                    'product_id'    => $model->product_id,
                    'type'          => 'out',
                    'amount'        => $model->amount,
                    'current_stock' => $newStock
                ]);
            }
        });
    }

    public function transaction()
    {
        $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

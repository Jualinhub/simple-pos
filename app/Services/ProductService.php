<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductPriceHistory;
use App\Models\ProductStockHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

Class ProductService
{
    public function create($request, $type = 'product') 
    {
        return DB::transaction(function () use($request, $type) {
            $product = Product::create($request->all()+['type' => $type]);

            if($request->sell_price) {
                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'type'  => 'sell',
                    'price' => $request->sell_price,
                ]);
            }

            if($request->buy_price) {
                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'type'  => 'buy',
                    'price' => $request->buy_price,
                ]);
            }

            if($request->stock_tracked == 1) {
                ProductStockHistory::create([
                    'product_id' => $product->id,
                    'type'  => 'in',
                    'amount' => $request->current_stock,
                    'current_stock' => $request->current_stock
                ]);
            }

            if($request->image) {
                $imageName = $product->name.'.'.$request->image->extension();
                $request->image->storeAs('products', $imageName);  

                $product->image = storage_path('public/products'.$imageName);
                $product->save();
            }

            return $product;
        });
    }

    public function update($request, $product)
    {
        return DB::transaction(function() use($request, $product) {
            $product->update($request->all());
            $product->save();

            // calculate new price
            if($request->buy_price != $product->buyPrice()) {
                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'type'  => 'buy',
                    'price' => $request->buy_price,
                ]);
            }

            if($request->sell_pricee != $product->sellPrice()) {
                ProductPriceHistory::create([
                    'product_id' => $product->id,
                    'type'  => 'sell',
                    'price' => $request->sell_price,
                ]);
            }

            // calculate new stock
            if($request->current_stock != $product->current_stock() && $request->stock_tracked == 1) {
                if($request->current_stock < $product->current_stock()) {
                    $amount = $product->current_stock() - $request->current_stock;
                    $type = 'out';
                    $current_stock = $request->current_stock;
                } else {
                    $amount = $request->current_stock - $product->current_stock();
                    $type = 'in';
                    $current_stock = $request->current_stock;
                }   

                ProductStockHistory::create([
                    'product_id' => $product->id,
                    'type'  => $type,
                    'amount' => $amount,
                    'current_stock' => $current_stock
                ]);
            }

            if($request->image) {
                $imageName = $product->name.'.'.$request->image->extension();
                $request->file('image')->move('products',$imageName);
                
                $product->image = asset('products/'.$imageName);
                $product->save();
            }
        });
    }

    public function delete($product)
    {
        return DB::transaction(function() use($product) {
            ProductPriceHistory::where('product_id', $product->id)->delete();
            ProductStockHistory::where('product_id')->delete();
            $product->delete();
        });

    }
}
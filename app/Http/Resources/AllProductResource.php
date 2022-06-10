<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllProductResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = array();

        foreach($this->collection as $item) {
            $in_cart = DB::table('carts')
                            ->select('id','product_id','user_id','amount')
                            ->where(['product_id' => $item->id, 'user_id' => Auth::user()->id])
                            ->first()
                            ->amount ?? 0;
            
            array_push($products, [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code,
                'stock_tracked' => $item->stock_tracked,
                'stock' => $item->current_stock(),
                'image' => $item->image ?? asset('image/default_product_image.png'),
                'price' => $item->sellPrice(),
                'in_cart' => $in_cart
            ]);
        }

        return $products;
    }
}

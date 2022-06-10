<?php

namespace App\Http\Resources;

use App\Services\CartService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $carts = array();
        $cartService = new CartService();

        foreach($this->collection as $item) {   
            $eachTotal = $cartService->getEachTotal($item);
            if($item->type == "manual") {
                $product = [
                    'name' => $item->name,
                    'price' => $item->price,
                ];
            } else {
                $product = [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->sellPrice(),
                    'taxName' => $item->product->tax->name ?? null
                ];
            }
            
            array_push($carts, [
                'id' => $item->id,
                'amount' => $item->amount,
                'total'  => $eachTotal['sub_total'],
                'tax' => $eachTotal['tax'],
                'product' => $product
            ]);
        }

        return $carts;
    }
}

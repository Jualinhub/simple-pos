<?php

namespace App\Http\Controllers\Api\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function get(CartService $cartService)
    {
        $carts = $cartService->getAll();
        $countCart = $cartService->getSubTotal($carts);

        return response([
            'success'   => true,
            'message'   => 'Cart found',
            'subtotal'  => $countCart['sub_total'],
            'taxes'     => $countCart['taxes'],
            'grandTotal' => $countCart['grand_total'],
            'data'      => new CartResource($carts)
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'numeric|exists:products,id',
            'amount'    => 'numeric|min:0',
        ]);

        // check if stock available 
        
        $product = Product::find($request->product_id);
        
        if($request->type != "manual" && ($product->stock_tracked && $product->current_stock() < 1)) {
            return response(['success' => false, 'message' => 'Product stock is empty'], 400);
        }

        $user = Auth::user();

        // insert into cart table
        DB::transaction(function() use($request, $user) {
            
            // if amount == 0, then delete the cart
            if($request->amount == 0) {
                Cart::where(['product_id' => $request->product_id, 'user_id' => $user->id])->delete();
            } else {
                Cart::updateOrCreate(
                    ['product_id' => $request->product_id, 'user_id' => $user->id],
                    $request->all()+['user_id' => $user->id]
                );
            }
            
        });

        return response([
            'success' => true, 
            'message' => 'added to cart!', 
            'data' => [
                'product_id'    => $request->product_id,
                'in_cart'       => $request->amount
            ]
        ],200);
    }

    public function manualInput(Request $request)
    {
        $request->validate([
            'name'      => 'sometimes|nullable',
            'sell_price'     => 'sometimes|nullable|numeric|min:0'
        ]);

        $user = Auth::user();
        DB::transaction(function () use($request, $user) {
            $product = Product::where(['type' => 'manual_input', 'name' => $request->name])->first();

            if(!$product) {
                $productService = new ProductService();
                $product = $productService->create($request, 'manual_input');
            }
            
            // add to cart
            Cart::updateOrCreate(
                ['product_id' => $product->id, 'user_id' => $user->id],
                $request->all()+['user_id' => $user->id]
            );
        });

    }

    public function clear() 
    {
        $user = Auth::user();

        DB::transaction(function() use($user) {
            Cart::where(['user_id' => $user->id])->delete();
        });

        return response(['success' => true, 'message' => 'Cart cleared!'],200);
    }
}

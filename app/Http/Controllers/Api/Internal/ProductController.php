<?php

namespace App\Http\Controllers\Api\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $products = Product::where(['type' => 'product']);

        if($request->q) {
            $products = $products->where('name','like','%'.$request->q.'%')
                                 ->orWhere('code','like','%'.$request->q.'%');
        }
        
        $products = $products->get()->take(30);
        $productResource = new AllProductResource($products);

        return response(['success' => true, 'message' => 'Yeeay, Success get products', 'data' => $productResource],200);
    } 
}

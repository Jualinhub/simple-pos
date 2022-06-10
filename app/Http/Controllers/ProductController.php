<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::whereNotIn('type', ['manual_input'])->orderBy('id', 'desc')->paginate(30);
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'code'      => 'sometimes|nullable|unique:products',
            'buy_price'     => 'required|numeric|min:0',
            'sell_price'     => 'required|numeric|min:0',
            'tax_id'    => 'sometimes|nullable|numeric',
            'description' => 'sometimes|nullable',
            'image'     => 'sometimes|nullable|image',
            'stock_tracked' => 'sometimes|nullable',
            'current_stock' => 'sometimes|nullable|numeric|min:0'
        ]);
        
        $save = $this->productService->create($request);

        if($save) {
            return redirect()->route('product.index')->with('success','Product created!');
        } else {
            return redirect()->back()->with('error','The product not saved!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'      => 'required',
            'code'      => 'sometimes|nullable|unique:products,code,'.$product->id,
            'buy_price'     => 'required|numeric|min:0',
            'sell_price'     => 'required|numeric|min:0',
            'tax_id'    => 'sometimes|nullable|numeric',
            'description' => 'sometimes|nullable',
            'image'     => 'sometimes|nullable|image'
        ]);
        
        $this->productService->update($request, $product);
        return redirect()->route('product.index')->with('success','Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()->route('product.index')->with('success', 'Product deleted!');
    }
}

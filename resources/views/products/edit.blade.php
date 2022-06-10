@extends('layouts.app', ['title' => 'Edit Product - '.$product->name])

@section('content')
<form action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data" method="POST">
    @csrf @method('PUT')
    <div class="mt-4 grid md:grid-cols-3 grid-cols-1 gap-4 w-full">
        <div class="md:col-span-2 bg-white rounded-xl p-4 shadow-xl">
            <div class="mb-3">
                <label for="" class="block mb-1 text-sm text-gray-400">Product Name</label>
                <input type="text" value="{{ old('name', $product->name) }}" name="name" placeholder="Product Name..." class="@error('name') border-red-600 @enderror w-full p-3 rounded border border-gray-300 text-xl">
                @error('name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-3">
                <div class="">
                    <label for="" class="block mb-1 text-sm text-gray-400">Buy Price</label>
                    <input type="number" value="{{ old('buy_price', $product->buyPrice()) }}" name="buy_price" placeholder="Buy Price" class="@error('buy_price') border-red-600 @enderror w-full p-2 rounded border border-gray-300">
                    @error('buy_price')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div class="">
                    <label for="" class="block mb-1 text-sm text-gray-400">Sell Price</label>
                    <input type="number" value="{{ old('sell_price', $product->sellPrice()) }}" name="sell_price" placeholder="Sell Price" class="@error('sell_price') border-red-600 @enderror w-full p-2 rounded border border-gray-300">
                    @error('sell_price')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div class="" id="taxField">
                    <label for="" class="block mb-1 text-sm text-gray-400">Product Tax</label>
                    <select name="tax_id" id="taxId" class="w-full p-2 rounded border text-gray-500 border-gray-300 @error('tax_id') border-red-600 @enderror">
                        <option value="">Select Tax or leave it blank</option>
                        @foreach(\App\Models\Tax::all() as $tax)
                        <option @if(old('tax_id', $product->tax_id) == $tax->id) selected @endif value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                    @error('tax_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div class="" @if(!$product->tax_id) style="display: none" @endif id="taxTypeField">
                    <label for="" class="block mb-1 text-sm text-gray-400">Tax Type</label>
                    <select name="tax_type" id="tax_type" @if(!$product->tax_id) disabled @endif class="w-full p-2 rounded border text-gray-500 border-gray-300 @error('tax_id') border-red-600 @enderror">
                        <option @if(old('tax_type', $product->tax_type) == 'exclude') selected @endif value="exclude">Exclude</option>
                        <option @if(old('tax_type', $product->tax_type) == 'include') selected @endif value="include">Include</option>
                    </select>
                    @error('tax_id')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="block mb-1 text-sm text-gray-400">Product Description</label>
                <textarea name="description" id="" class="w-full border border-gray-300 p-2 rounded @error('description') border-red-600 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

        </div>

        <div class="bg-white rounded-xl p-4 shadow-xl relative">
            <div class="mb-3">
                <label for="" class="block mb-1 text-sm text-gray-400">Product Code</label>
                <input type="text" value="{{ old('code', $product->code) }}" name="code" placeholder="Product Code / SKU" class="@error('code') border-red-600 @enderror w-full p-3 rounded border border-gray-300 text-xl">
                @error('code')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div class="mb-5">
                <label for="" class="block mb-1 text-sm text-gray-400">Upload Image</label>
                <input type="file" name="image" class="w-full border border-gray-300 rounded" id="">
                @error('image')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="" class="block mb-1 text-sm text-gray-400">Stock Tracked?</label>
                <div class="flex gap-6">
                    <div class="form-check">
                        <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="stock_tracked" value="1" id="tracked" @if(old('stock_tracked', $product->stock_tracked) == 1) checked @endif>
                        <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                          Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="stock_tracked" value="0" id="notTracked" @if(old('stock_tracked', $product->stock_tracked) == 0) cheked @endif>
                        <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2" >
                          No
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="stockField" @if($product->stock_tracked == 0) style="display: none" @endif>
                <label for="" class="block mb-1 text-sm text-gray-400">Current Stock</label> 
                <input type="number"  id="current_stock" @if($product->stock_tracked == 0) disabled @endif name="current_stock" min="0" placeholder="Current Stock" value="{{ old('current_stock',$product->current_stock()) }}" class="@error('current_stock') border-red-600 @enderror w-full p-2 rounded border border-gray-300">
                @error('current_stock')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="absolute bottom-0 left-0 p-4 w-full">
                <button type="submit" class="bg-primary p-3 rounded text-white w-full">Save</button>
            </div>

        </div>
    </div>
</form>
@endsection

@push('js')
    <script>
        $("#taxField").on('change', function() {
            if($("#taxId").val() != '') {
                $("#taxTypeField").show();
                $("#tax_type").prop('disabled',false);
            } else {
                $("#taxTypeField").hide();
                $("#tax_type").prop('disabled',true);
            }
        });

        $("#tracked").on('click', function() {
            $("#stockField").show()
            $("#current_stock").prop('disabled', false)
        });

        $("#notTracked").on('click', function() {
            $("#stockField").hide()
            $("#current_stock").prop('disabled', true)
        })
    </script>
@endpush
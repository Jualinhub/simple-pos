@extends('layouts.pos', ['title' => 'POS Apps'])

@section('content')
<div class="w-full h-screen py-4 px-6">
    <div class="w-full flex justify-between items-center">
        <div class="flex items-center gap-4">
            <x-logo />
            <span class="text-xl">{{ Carbon\Carbon::now()->format('l, d M Y') }}</span>
        </div>
        <div class="flex gap-2">
            <div class="bg-primary rounded-full text-white py-3 px-6">
                {{ auth()->user()->name }}
                <i class="fa-solid fa-circle-user ml-4"></i>
            </div>
            <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 text-xl flex items-center justify-center rounded-full w-12 h-12 text-white">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </div>

    <div class="w-full mt-12 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="col-span-2">
            <x-product-pos />
        </div>

        <div>
            <div class="bg-white w-full rounded-lg shadow-lg">
               <div class="px-5 py-3">
                    <div class="flex justify-between items-center">
                        <span class=" text-xl">Transaction</span>
                        <button onclick="clearCart()" class="bg-red-600 hover:bg-red-700 rounded-full py-2 px-4 text-white">Clear</button>
                    </div>
               </div>

                <div class="p-5 border-t border-gray-200 relative" style="height: 65vh">
                    <x-product-cart />
                    <div id="summary" class="absolute bottom-0 w-full left-0 px-5 py-3 border-t border-gray-200">
                        <div class="flex justify-between text-gray-800">
                            <div>
                                <p>Sub Total</p>
                                <p>Tax</p>
                                <p>Discount</p>
                            </div>
                            <div class="text-right">
                                <p id="domSubTotal">Rp. 0</p>
                                <p id="domTax">Rp. 0</p>
                                <p id="domDiscount">Rp. 0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <label for="modalCustomInput" class="btn modal-button bg-primary text-white border-0">
                    <i class="fa-solid fa-keyboard"></i>
                </label>

                <label for="modalPaymentMethod" class="w-full cursor-pointer flex justify-between items-center hover:bg-blue-600 px-4 text-lg rounded bg-primary text-white py-2 font-semibold">
                    <div>Pay</div>
                    <div id="grandTotal">Rp. 0</div>
                </label>
                {{-- <button class="w-full flex justify-between items-center hover:bg-blue-600 px-4 text-lg rounded bg-primary text-white py-2 font-semibold">
                    <div>Pay</div>
                    <div id="grandTotal">Rp. 0</div>
                </button> --}}
            </div>

            <x-payment-method />

            <!-- Modal for manual input -->
            <input type="checkbox" id="modalCustomInput" class="modal-toggle" />
            <div class="modal" id="customInputDOM">
                <div class="modal-box bg-gray-50 text-gray-800 relative">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Manual Input</h3>
                        <label for="modalCustomInput" class="btn btn-sm btn-circle">✕</label>
                    </div>
                    
                    <div class="mt-3">
                        <div class="mb-3">
                            <label for="" class="block mb-1">Product Name</label>
                            <input type="text" id="customName" class="w-full py-2 px-3 rounded border border-gray-200">
                            <small id="errorCustomName" class="text-red-600" style="display:none">This field is required</small>
                        </div>

                        <div class="mb-3">
                            <label for="" class="block mb-1">Product Price</label>
                            <input type="text" id="customPrice" class="w-full py-2 px-3 rounded border border-gray-200">
                            <small id="errorCustomPrice" class="text-red-600" style="display:none">This field is required</small>
                        </div>

                        {{-- <div class="modal-action">
                            <a onclick="inputManual()" href="#" class="btn">Add to cart</a>
                        </div> --}}
                        <button onclick="inputManual()" class="w-full py-3 justify-center bg-primary rounded-lg text-white modal-action">Add to Cart</button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        function number_format(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function clearCart() {
            let data = {
                _token: "{{ csrf_token() }}",
            }

            $.ajax({
                url:  `{{ route('api-in.cart.clear') }}`,
                type: "POST",
                data: data,
                success: function (data) {
                    $("#carts").empty();

                    loadCart();
                    getProducts();
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        function inputManual() {
            let data = {
                _token: "{{ csrf_token() }}",
                type: "manual",
                name: $("#customName").val(),
                sell_price: $("#customPrice").val(),
                amount: 1
            }

            if($("#customName").val() == '') {
                $("#customName").addClass('border border-red-600');
                $("#errorCustomName").show();
            }

            if($("#customPrice").val() == '') {
                $("#customPrice").addClass('border border-red-600');
                $("#errorCustomPrice").show();
            }

            if($("#customName").val() != '' && $("#customPrice").val() != '') {
                $.ajax({
                url:  `{{ route('api-in.cart.manual-input') }}`,
                type: "POST",
                data: data,
                success: function (data) {
                    $("#carts").empty();

                    loadCart();
                    getProducts();
                    
                    $("#modalCustomInput").prop('checked', false);
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
            }
        }

    </script>
@endpush
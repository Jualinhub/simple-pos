<div id="carts"></div>

<div class="h-full w-full flex pt-8 justify-center" id="emptyCart">
    Cart is Empty
</div>

@push('js')
    <script src="{{ asset('components/cart-items.js') }}"></script>
    <script>
        window.onload = loadCart();

        function loadCart() {
            
            $.ajax({
                url:  `{{ route('api-in.cart.get') }}`,
                type: "GET",
                success: function (data) {
                    $("#carts").empty();

                    if(data.data.length > 0) {
                        $("#emptyCart").hide()
                    } else {
                        $("#emptyCart").show()
                    }

                    for(let i = 0; i < data.data.length; i++) {
                        $("#carts").append(CartDOM(data.data[i]))
                    }
                    sumGrandTotal(data)
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        function deleteCart(productId) {
            let data = {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                amount: 0,
            }

            $.ajax({
                url:  `{{ route('api-in.cart.create') }}`,
                type: "POST",
                data: data,
                success: function (data) {
                    loadCart()
                    getProducts()
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        function editCart(el, productId) {
            let amount = $(el).val();

            if(!amount) {
                $(el).val(0);

                amount = 0;
            }
            
            let data = {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                amount: amount,
            }

            $.ajax({
                url:  `{{ route('api-in.cart.create') }}`,
                type: "POST",
                data: data,
                success: function (data) {
                    loadCart()
                    getProducts()
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        function sumGrandTotal(data) {
            $("#grandTotal").html('Rp. '+number_format(data.grandTotal))
            $("#domSubTotal").html('Rp. '+number_format(data.subtotal))
            $("#domTax").html('Rp. '+number_format(data.taxes))

            $("#paidAmountInput").val(data.grandTotal)
        }

    </script>
@endpush
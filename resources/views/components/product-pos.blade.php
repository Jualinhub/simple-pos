<div class="search w-full">
    <input type="text" id="searchProduct" placeholder="Find Product Name or Code ..." class="w-full text-xl  rounded-xl border border-gray-300 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 py-3 px-4">
</div>
<div class="mt-4">
    <div class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-2" id="products"></div>
    </div>
</div>

@push('js')
    <script src="{{ asset('components/product-items.js') }}"></script>
    <script>
        window.onload = getProducts();

        $(document).ready(function() {
            $("#searchProduct").on('input', function() {
                let data = {
                    q: $(this).val()
                }
                getProducts(data)
            });
        })

        function getProducts(data = null) {
            $.ajax({
                url:  `{{ route('api-in.product.all') }}`,
                type: "GET",
                data: data,
                success: function (data) {
                    $("#products").empty();
                    for(let i = 0; i < data.data.length; i++) {
                        $("#products").append(ProductDOM(data.data[i]))
                    }
                },

                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        function addProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            
            let amount = parseInt(inputVal)+1;
            $(el).parent().find('.product-amount').val(amount);

            createCart(amount, productId);
        }

        function minusProduct(el, productId) {
            let inputVal = $(el).parent().find('.product-amount').val();
            
            if(inputVal == 0) {
                return false;
            }
            let amount = parseInt(inputVal)-1;
            $(el).parent().find('.product-amount').val(amount);

            createCart(amount, productId);
        }

        function handleInput(el, productId) {
            let amount = $(el).val();

            createCart(amount, productId);
        }

        function createCart(amount, productId) {
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
                },

                error: function (data) {
                    return alert('Invalid input')
                }
            });
        }

    </script>
@endpush
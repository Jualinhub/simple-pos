
function ProductDOM(product) {
    var stockDOM = '';

    if(product.stock_tracked == 0) {
        stockDOM = `
            <p class="text-xs"><span class="bg-yellow-100 font-semibold italic rounded">Not tracked</span></p>
        `;
    } else {
        stockDOM = `
            <p class="text-xs"><span class="bg-green-100 font-semibold rounded">`+product.stock+`</span> items</p>
        `;
    }

    return `
    <div class="product bg-white rounded-lg w-full flex gap-3 p-2 shadow-lg" id="product-`+product.id+`">
        <img class="object-cover w-20 h-24 rounded-lg" src="`+product.image+`" alt="">
        <div class="w-full">
            <span class="font-semibold text-gray-800 text-md">`+product.name+`</span>
            <div class="flex justify-between w=full">
                <div class="text-xs">
                    <p>Code</p>
                    <p>Price </p>
                </div>

                <div class="text-xs text-right">
                    <p>`+product.code+`</p>
                    <p>Rp. `+number_format(product.price)+`</p>
                </div>
            </div>
            <div class="flex justify-between items-end">
                `+stockDOM+`
                <div class="flex gap-1 justify-end mt-2 addToCart" id="addToCart`+product.id+`">
                    <button onclick="minusProduct(this, `+product.id+`)" class="minus bg-gray-100 border border-gray-400 rounded px-2"><i class="fa-solid fa-minus text-gray-500"></i></button>
                    <input onchange="handleInput(this, `+product.id+`)" type="text" class="px-1 w-9 text-gray-700 text-center product-amount rounded border border-gray-400" value="`+product.in_cart+`">
                    <button onclick="addProduct(this, `+product.id+`)" class="plus bg-gray-100 border border-gray-400 rounded px-2"><i class="fa-solid fa-plus text-gray-500"></i></button>
                </div>
            </div>
        </div>
    </div>
    `;
}


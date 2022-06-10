function CartDOM(cart) {

    var domTax = '';

    if(cart.tax > 0) {
        var domTax = `
            <small class="text-xs text-gray-800 bg-yellow-100">+ Rp. `+number_format(cart.tax)+` (`+cart.product.taxName+`)</small>
        `;
    }

    return `
    <div class="mb-3" id="">
        <div class="flex justify-between">
            <div class="flex gap-2">
                <input min="0" oninput="editCart(this, `+cart.product.id+`)" value="`+cart.amount+`" class="border text-gray-800 border-gray-200 text-sm text-center rounded" style="width: 40px">
                <div class="leading-none text-gray-800"><span>`+cart.product.name+`</span> <br> <small class="text-xs">@ Rp. `+number_format(cart.product.price)+`</small></div>
            </div>

            <div class="flex gap-3 items-center">
                <div class="leading-none text-right text-gray-800">
                    <span class="leading-none"> Rp. `+number_format(cart.total)+`</span> <br>
                    `+domTax+`
                </div>
                <button onclick="deleteCart(`+cart.product.id+`)" class="text-red-600 w-6 h-6 rounded-full hover:text-red-700 hover:shadow  text-sm"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
    </div>
    `;
}
{{-- desktop  --}}
<div class="w-44 px-3 hidden md:block md:fixed">
    <div class="flex justify-center">
        <x-logo />
    </div>

    <div class="menus mt-10">
        <a href="{{ route('pos.index') }}" class="bg-white shadow-lg w-full block rounded-xl px-4 py-6 menu text-center">
            <div class="mb-3">
                <i class="fa-solid fa-cash-register text-4xl text-gray-500"></i>
            </div>
            <span class="text-lg">Cashier</span>
        </a>

        <a href="{{ route('home') }}" class="bg-white @if(Route::is('home')) active @endif shadow-lg w-full block rounded-xl px-4 py-6 menu text-center">
            <div class="mb-3">
                <i class="fa-solid fa-chart-pie  text-4xl text-gray-500"></i>
            </div>
            <span class="text-lg">Dashboard</span>
        </a>

        <a href="{{ route('product.index') }}" class="bg-white @if(Route::is('product.*')) active @endif  shadow-lg w-full block rounded-xl px-4 py-6 menu text-center">
            <div class="mb-3">
                <i class="fa-solid fa-box-open  text-4xl text-gray-500"></i>
            </div>
            <span class="text-lg">Products</span>
        </a>

        <a href="{{ route('transaction.index') }}" class="bg-white @if(Route::is('transaction.*')) active @endif shadow-lg w-full block rounded-xl px-4 py-6 menu text-center">
            <div class="mb-3">
                <i class="fa-solid fa-chart-line  text-4xl text-gray-500"></i>
            </div>
            <span class="text-lg">Transaction</span>
        </a>

        <a href="" class="bg-white shadow-lg w-full block rounded-xl px-4 py-6 menu text-center">
            <div class="mb-3">
                <i class="fa-solid fa-gear  text-4xl text-gray-500"></i>
            </div>
            <span class="text-lg">Setting</span>
        </a>
    </div>
</div>
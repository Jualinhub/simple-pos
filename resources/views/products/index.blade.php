@extends('layouts.app', ['title' => 'Products'])

@section('content')
    <div class="py-4 md:py-6 relative min-h-screen">
        <table class="table table-fixed w-full bg-white shadow-xl">
            <thead class="text-dark">
                <th class="p-2" style="width: 5%">#</th>
                <th class="p-2 text-left">Code</th>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Price</th>
                <th class="p-2 ">Option</th>
            </thead>

            <tbody>
            @foreach ($products as $product)
            <tr class="border-b border-gray-200">
                <td class="p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $product->code }}</td>
                <td class="p-2">{{ $product->name }}</td>
                <td class="p-2">Rp. {{ number_format($product->sellPrice()) }}</td>
                <td class="flex justify-center gap-3 p-2">
                    <a href="{{ route('product.edit', $product->id) }}" class="text-amber-500"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return alert('Are you sure want to do this action?')" type="submit" class="text-red-600"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
        <div class="fixed bottom-10 right-10">
            <a href="{{ route('product.create') }}" class="bg-primary hover:bg-blue-600 text-white px-6 py-4 rounded-xl">Add Product</a>
        </div>
    </div>
@endsection
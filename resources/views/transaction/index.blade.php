@extends('layouts.app', ['title' => 'Transactions'])

@section('content')
    <div class="py-4 md:py-6 relative min-h-screen">
        <table class="table table-fixed w-full bg-white shadow-xl">
            <thead class="text-dark">
                <th class="p-2" style="width: 5%">#</th>
                <th class="p-2 text-left">Date</th>
                <th class="p-2 text-right">Sub Total</th>
                <th class="p-2 text-right">Tax</th>
                <th class="p-2 text-right">Discount</th>
                <th class="p-2 text-right">Grand Total</th>
                <th class="p-2 text-center">Payment</th>
                <th class="p-2 text-center">Option</th>
            </thead>

            <tbody>
            @foreach ($transactions as $transaction)
            <tr class="text-sm @if($transaction->refunded_at) refunded text-red-800 @endif" >
                <td class="p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                <td class="p-2 text-right">Rp. {{ number_format($transaction->sub_total) }}</td>
                <td class="p-2 text-right">Rp. {{ number_format($transaction->tax) }}</td>
                <td class="p-2 text-right">Rp. {{ number_format($transaction->discount) }}</td>
                <td class="p-2 text-right">Rp. {{ number_format($transaction->grand_total) }}</td>
                <td class="p-2 text-center">{{ $transaction->paymentMethod->name ?? '-' }}</td>
                <td class="p-2">
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('transaction.show',$transaction) }}" class="text-primary">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        @if(!$transaction->refunded_at)
                        <form action="{{ route('transaction.refund',$transaction) }}" method="POST">
                            @csrf
                            <button onclick="return confirm('Are you sure want to refund this transaction?')" class="text-red-600"><i class="fa-solid fa-arrow-rotate-left"></i></button>
                        </form>
                        @else 
                        <small class="text-red-600">Refunded</small>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
        {{ $transactions->links() }}
        
    </div>
@endsection
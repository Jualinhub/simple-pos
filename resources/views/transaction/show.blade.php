@extends('layouts.app', ['title' => 'Transaction '.$transaction->code])

@section('content')
    <div class="w-full p-6 md:p-0 md:mt-5 flex justify-center">
        <div class="w-full bg-white p-5 rounded shadow-xl">
            <h1 class="text-2xl"></h1>
            <div class="mt-3 flex justify-between">
                <div>
                    <p>Date</p>
                    <p>Operator</p>
                    <p>Payment Method</p>
                    <p>Paid Amount</p>
                    <p>Change Amount</p>
                </div>

                <div class="text-right">
                    <p>{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    <p>{{ $transaction->user->name }}</p>
                    <p>{{ $transaction->paymentMethod->name }}</p>
                    <p>Rp. {{ number_format($transaction->paid_amount) }}</p>
                    <p>Rp. {{ number_format($transaction->change) }}</p>
                </div>
            </div>
            <div class="mt-5">
                <span class="text-sm text-gray-600">Detail Transaction</span>
                @foreach ($transaction->details as $item)
                <div class="mt-2 flex justify-between">
                    <p class="leading-none">
                        {{ $item->product->name }} <br>
                        <small class="text-xs">{{ $item->amount.'x '.number_format($item->price) }}</small>
                    </p>
                    <p class="leading-none text-right">
                        Rp. {{ number_format($item->total) }} <br>
                        @if($item->tax > 0) <small class="text-xs">+ Rp. {{ number_format($item->tax) }} (Tax)</small> @endif
                    </p>
                </div>
                @endforeach
                <div class="mt-2 pt-2 border-t border-gray-200">
                    <div class="flex justify-between">
                        <p>Sub Total</p>
                        <p>Rp. {{ number_format($transaction->sub_total) }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Tax</p>
                        <p>Rp. {{ number_format($transaction->tax) }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Discount</p>
                        <p>-Rp. {{ number_format($transaction->discount) }}</p>
                    </div>

                    <div class="flex justify-between font-semibold bg-gray-100 py-1">
                        <p>Grand Total</p>
                        <p>Rp. {{ number_format($transaction->grand_total) }}</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-3 gap-2">
                    <div class="col-span-2">
                        <button onclick="printThis()" class="w-full py-2 bg-primary rounded text-white font-medium text-lg">Print</button>
                    </div>
                    <a href="{{ route('transaction.index') }}" class="py-2 text-lg bg-red-600 text-white rounded text-center">Close</a>
                </div>
            </div>

        </div>
    </div>
@endsection
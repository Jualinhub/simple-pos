<?php

namespace App\Services;

use App\Models\RefundTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class TransactionService
{
    public function refund($transaction)
    {
        DB::transaction(function () use($transaction) {
            $transaction->refunded_at = Carbon::now();
            
            RefundTransaction::create([
                'transaction_id' => $transaction->code,
                'sub_total' => $transaction->sub_total,
                'discount' => $transaction->discount,
                'grand_total' => $transaction->grand_total,
                'notes' => 'Refund for Transaction #'.$transaction->code
            ]);

            $transaction->save();
        });
    }
}
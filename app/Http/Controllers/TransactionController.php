<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function index(Request $request)
    {
        $transactions = Transaction::paginate(30);
        return view('transaction.index' , compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show',compact('transaction'));
    }

    public function doRefund(Transaction $transaction, TransactionService $transactionService)
    {
        $transactionService->refund($transaction);

        return redirect()->back()->with('success','Transaction refunded!');
    }
}

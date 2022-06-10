<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\CartService;
use Illuminate\Http\Request;

class PosController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('pos.index');
    }

    public function storeTransaction(Request $request, CartService $cart)
    {
        $transaction = $cart->storeTransaction($request);
        return redirect()->route('pos.detail-transaction',$transaction->code);
    }   

    public function detailTransaction(Transaction $transaction)
    {
        return view('pos.detail-transaction',compact('transaction'));
    }
}

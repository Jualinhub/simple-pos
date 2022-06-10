<?php 

namespace App\Services;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class CartService
{
    public function getAll()
    {
        $user = Auth::user();
        $carts = Cart::where(['user_id' => $user->id])->get();

        if(!$carts) {
            return response(['success' => false, 'message' => 'Cart is empty!'],200);
        }

        return $carts;
    }

    public function getSubTotal($carts)
    {
        $subTotal = 0;
        $taxes = 0;
        foreach($carts as $cart) {
            if($cart->type != "manual" && $cart->product->sellPrice() > 0) {
                if($cart->product->tax_id) {
                    if($cart->product->tax_type == 'include') {
                        $countIncl = $this->countInclTax($cart->product->sellPrice() * $cart->amount, $cart->product->tax->percent);
    
                        $taxes += $countIncl['tax'];
                        $subTotal += $countIncl['total'];
                    } else {
                        $taxes += $this->countExclTax($cart->product->sellPrice() * $cart->amount, $cart->product->tax->percent);
                        $subTotal += $cart->product->sellPrice() * $cart->amount;
                    }
    
                } else {
                    $subTotal += $cart->product->sellPrice() * $cart->amount;
                }
            }
            
        }

        return [
            'sub_total' => $subTotal,
            'taxes'     => $taxes,
            'grand_total'     => $subTotal + $taxes
        ];
    }

    public function getEachTotal($cart)
    {
        $subTotal = 0;
        $taxes = 0;

        if($cart->type != "manual" && $cart->product->sellPrice() > 0) {
            if($cart->product->tax_id) {
                if($cart->product->tax_type == 'include') {
                    $countIncl = $this->countInclTax($cart->product->sellPrice() * $cart->amount, $cart->product->tax->percent);

                    $taxes += $countIncl['tax'];
                    $subTotal += $countIncl['total'];
                } else {
                    $taxes += $this->countExclTax($cart->product->sellPrice() * $cart->amount, $cart->product->tax->percent);
                    $subTotal += $cart->product->sellPrice() * $cart->amount;
                }

            } else {
                $subTotal += $cart->product->sellPrice() * $cart->amount;
            }
        }

        return [
            'sub_total' => $subTotal,
            'tax'     => $taxes,
        ];
    }

    public function countInclTax($amount, $tax) {
        $afterTax = ceil((100/(100+$tax)) * $amount );
        return [
            'total' => $afterTax,
            'tax'   => $amount - $afterTax
        ]; 
    }

    public function countExclTax($amount, $tax) 
    {
        return $amount * ($tax/100);
    }

    public function storeTransaction($request)
    {
        return DB::transaction(function () use($request) {
            // get cart detail
            $carts = $this->getAll();

            // calculate grand total
            $subTotal = $this->getSubTotal($carts);

            // save to transaction
            $transaction = Transaction::create([
                'user_id' => Auth::user()->id,
                'sub_total' => $subTotal['sub_total'],
                'tax'   => $subTotal['taxes'],
                'grand_total' => $subTotal['grand_total'],
                'paid_amount' => $request->paid_amount,
                'change_amount' => $subTotal['grand_total'] - $request->paid_amount,
                'payment_method_id' => $request->payment,
            ]);  

            foreach($carts as $cart) {
                $eachTotal = $this->getEachTotal($cart);
                TransactionDetail::create([
                    'transaction_id'    => $transaction->code,
                    'product_id'        => $cart->product_id,
                    'amount'            => $cart->amount,
                    'price'             => $cart->product->sellPrice(),
                    'discount'          => 0,
                    'tax'               => $eachTotal['tax'],
                    'total'             => $eachTotal['sub_total']
                ]);   
                
                Cart::find($cart->id)->delete();
            }

            return $transaction;
            
        });
    }
}
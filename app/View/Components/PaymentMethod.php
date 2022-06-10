<?php

namespace App\View\Components;

use App\Models\PaymentMethod as ModelsPaymentMethod;
use Illuminate\View\Component;

class PaymentMethod extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $paymentMethods = ModelsPaymentMethod::all();
        return view('components.payment-method', compact('paymentMethods'));
    }
}

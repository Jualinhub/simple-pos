<!-- Modal for payment method -->
<input type="checkbox" id="modalPaymentMethod" class="modal-toggle" />
<div class="modal" id="customInputDOM">
    <div class="modal-box bg-gray-50 text-gray-800 relative">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold">Choose Payment Method</h3>
            <label for="modalPaymentMethod" class="btn btn-sm btn-circle">✕</label>
        </div>
        
        <div class="mt-3 py-3 border-t border-gray-200">
            <form action="{{ route('pos.store-transaction') }}" method="POST">
            @csrf
            
            

            @foreach ($paymentMethods as $item)
            <div class="form-control payments">
                <label class="label cursor-pointer">
                  <span class="label-text text-lg">{{ $item->name }}</span> 
                  <input type="radio" name="payment" value="{{ $item->id }}" class="radio select-payment checked:bg-blue-500" @if($item->id == 1) checked @endif />
                </label>
            </div>

            @if($item->id == 1) 
            <div class="mb-2 p-1 flex items-center w-full" id="paidAmount">
                <label for="" class="block mb-1 text-xs w-44">Paid Amount</label>
                <input type="number" name="paid_amount" id="paidAmountInput"  class="w-full rounded py-2 px-3 border">
            </div>
            @endif
            @endforeach
            <button type="submit" class="w-full py-3 justify-center bg-primary rounded-lg text-white modal-action">Pay </button>
            </form>
        </div>

    </div>
</div>

@push('js')
    <script>
        $(".select-payment").on('click', function() {
            if($(this).val() == 1) {
                $("#paidAmount").show();
            } else {
                $("#paidAmount").hide();
            }
        })
    </script>
@endpush
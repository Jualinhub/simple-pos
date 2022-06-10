<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sub_total', 'code', 'discount','tax', 'grand_total', 'paid_amount', 'change_amount', 'detail_product', 'payment_method_id', 'refunded_at'
    ];

    protected $primaryKey = 'code';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->code = $model->generateCode();
        });
    }

    private function generateCode()
    {
        $time = Carbon::now()->format('dmy');
        $rand = rand(000000,999999);

        $code = $time.'-'.$rand;

        $check = $this->checkCode($code);
        
        if($check > 0) {
            $this->generateCode();
        }

        return $code;
    }

    private function checkCode($code)
    {
        return Transaction::where('code', $code)->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function details() 
    {
        return $this->hasMany(TransactionDetail::class,'transaction_id','code');
    }
}

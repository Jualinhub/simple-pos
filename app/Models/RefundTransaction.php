<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id','sub_total','discount','tax','grand_total','notes'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

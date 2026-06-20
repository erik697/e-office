<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvTransactionProduct extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'quantity'];

    public function transaction()
    {
        return $this->belongsTo(InvTransaction::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(InvProduct::class, 'product_id');
    }
}

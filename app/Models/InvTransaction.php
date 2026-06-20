<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvTransaction extends Model
{
    protected $fillable = ['type', 'status'];

    public function invTransactionProducts()
    {
        return $this->hasMany(InvTransactionProduct::class, 'transaction_id');
    }
}

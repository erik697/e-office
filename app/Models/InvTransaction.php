<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvTransaction extends Model
{
    protected $fillable = ['code', 'status', 'register', 'due_time' ,'note'];

    public function invTransactionProducts()
    {
        return $this->hasMany(InvTransactionProduct::class, 'transaction_id');
    }

    public function products()
    {
        return $this->belongsToMany(
            InvProduct::class,
            'inv_transaction_products',
            'transaction_id',
            'product_id'
        )->withPivot('quantity');
    }

}

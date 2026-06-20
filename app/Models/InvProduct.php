<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvProduct extends Model
{
    protected $fillable = ['code', 'name', 'description', 'category_id', 'location_id'];

    public function category()
    {
        return $this->belongsTo(InvCategory::class, 'category_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(InvLocation::class, 'location_id', 'id');
    }

    public function invTransactionProducts()
    {
        return $this->hasMany(InvTransactionProduct::class, 'product_id');
    }
}

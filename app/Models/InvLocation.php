<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvLocation extends Model
{
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(InvProduct::class, 'location_id');
    }
}

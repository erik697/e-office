<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvCategory extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function products()
    {
        return $this->hasMany(InvProduct::class, 'category_id');
    }
}

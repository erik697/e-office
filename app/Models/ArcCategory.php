<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArcCategory extends Model
{
    protected $fillable = ['name'];

    public function arcDocuments()
    {
        return $this->hasMany(ArcDocument::class, 'category_id');
    }
}

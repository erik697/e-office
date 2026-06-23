<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArcDocument extends Model
{
    protected $fillable = ['code', 'title', 'description', 'register', 'file_path', 'status', 'category_id', 'type'];

    public function category()
    {
        return $this->belongsTo(ArcCategory::class, 'category_id');
    }
}

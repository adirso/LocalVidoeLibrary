<?php
// app/Models/Movie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'path',
        'name',
        'description',
        'photo',
        'progress_time',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function captions()
    {
        return $this->hasMany(Subtitle::class);
    }
}

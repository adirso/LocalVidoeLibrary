<?php
// app/Models/Series.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = [
        'path',
        'name',
        'description',
        'photo',
        'season',
        'episode',
        'progress_time',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

}

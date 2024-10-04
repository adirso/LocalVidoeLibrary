<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'description',
        'progress_time',
        'series_id',
    ];

    // Relation with Series
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}

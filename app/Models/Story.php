<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $table = 'stories';
    protected $fillable = [
        'historical_id',
        'title',
        'content',
        'illustration',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class, 'historical_id');
    }
}

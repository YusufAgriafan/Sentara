<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $table = 'places';
    protected $fillable = [
        'name',
        'coordinate_id',
        'location',
        'era',
        'description',
    ];

    public function coordinate()
    {
        return $this->belongsTo(Coordinate::class, 'coordinate_id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'historical_id');
    }
}

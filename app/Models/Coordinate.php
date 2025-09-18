<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;
    protected $table = 'coordinate';
    protected $fillable = [
        'latitude',
        'longitude',
    ];

    public function places()
    {
        return $this->hasMany(Place::class, 'coordinate_id');
    }
}

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

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_places', 'place_id', 'class_id');
    }

    // Scope untuk filter places berdasarkan class
    public function scopeForClass($query, $classId)
    {
        return $query->whereHas('classes', function ($q) use ($classId) {
            $q->where('class.id', $classId);
        });
    }

    // Scope untuk places yang belum di-assign ke class tertentu
    public function scopeNotInClass($query, $classId)
    {
        return $query->whereDoesntHave('classes', function ($q) use ($classId) {
            $q->where('class.id', $classId);
        });
    }
}

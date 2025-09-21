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

    public function classes()
    {
        // Relasi many-to-many langsung dengan classes
        return $this->belongsToMany(ClassModel::class, 'class_stories', 'story_id', 'class_id');
    }

    // Scope untuk filter stories berdasarkan class
    public function scopeForClass($query, $classId)
    {
        return $query->whereHas('classes', function ($q) use ($classId) {
            $q->where('class.id', $classId);
        });
    }

    // Method untuk cek apakah story ini di-assign ke class tertentu
    public function isAssignedToClass($classId)
    {
        return $this->classes()->where('class.id', $classId)->exists();
    }

    // Method untuk cek apakah story ini tersedia untuk class tertentu (berdasarkan place)
    public function isAvailableForClass($classId)
    {
        return $this->place->classes()->where('class.id', $classId)->exists();
    }
}

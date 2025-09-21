<?php

namespace App\Models;

use App\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, SoftDeletes, UserTrackable;
    
    protected $table = 'stories';
    
    protected $fillable = [
        'historical_id',
        'title',
        'content',
        'illustration',
        'is_public',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'historical_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
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

    /**
     * Override educator edit permission for stories
     */
    protected function canEducatorEdit($user): bool
    {
        if (!$user->isEducator()) {
            return false;
        }

        // Educator can edit stories that are assigned to their classes
        return $this->classes()->whereHas('educator', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->exists();
    }
}

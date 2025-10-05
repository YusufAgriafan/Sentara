<?php

namespace App\Models;

use App\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes, UserTrackable;
    
    protected $table = 'places';
    
    protected $fillable = [
        'name',
        'coordinate_id',
        'location',
        'era',
        'description',
        'is_public',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function coordinate()
    {
        return $this->belongsTo(Coordinate::class, 'coordinate_id');
    }

    // Keep backward compatibility with user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'historical_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_places', 'place_id', 'class_id')
            ->withTimestamps();
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

    /**
     * Override educator edit permission for places
     */
    protected function canEducatorEdit($user): bool
    {
        if (!$user->isEducator()) {
            return false;
        }

        // Educator can edit places that are assigned to their classes
        return $this->classes()->whereHas('educator', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->exists();
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a specific role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the specified roles
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is educator
     *
     * @return bool
     */
    public function isEducator(): bool
    {
        return $this->hasRole('educator');
    }

    /**
     * Check if user is student
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Get the class list for this user (if student)
     */
    public function classList()
    {
        return $this->hasMany(ClassList::class, 'student_id');
    }

    /**
     * Get the classes this user teaches (if educator)
     */
    public function teachingClasses()
    {
        return $this->hasMany(ClassModel::class, 'educator_id');
    }

    /**
     * Get the classes this user is enrolled in (if student)
     */
    public function enrolledClasses()
    {
        return $this->hasManyThrough(ClassModel::class, ClassList::class, 'student_id', 'id', 'id', 'class_id');
    }

    /**
     * Get places created by this user
     */
    public function createdPlaces()
    {
        return $this->hasMany(Place::class, 'created_by');
    }

    /**
     * Get stories created by this user
     */
    public function createdStories()
    {
        return $this->hasMany(Story::class, 'created_by');
    }

    /**
     * Get geography models created by this user (educator)
     */
    public function createdGeographyModels()
    {
        return $this->hasMany(GeographyModel::class, 'educator_id');
    }

    /**
     * Get discussions created by this user
     */
    public function createdDiscussions()
    {
        return $this->hasMany(ClassDiscussion::class, 'user_id');
    }

    /**
     * Get all content created by this user
     */
    public function getAllCreatedContentAttribute()
    {
        $content = collect();
        
        if ($this->isEducator() || $this->isAdmin()) {
            $content = $content->merge($this->createdPlaces);
            $content = $content->merge($this->createdStories);
            $content = $content->merge($this->createdGeographyModels);
            $content = $content->merge($this->teachingClasses);
        }
        
        $content = $content->merge($this->createdDiscussions);
        
        return $content;
    }

    /**
     * Check if user can manage content (create, edit, delete)
     */
    public function canManageContent(): bool
    {
        return $this->isEducator() || $this->isAdmin();
    }
}

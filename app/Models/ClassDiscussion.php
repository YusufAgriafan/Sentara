<?php

namespace App\Models;

use App\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassDiscussion extends Model
{
    use HasFactory, SoftDeletes, UserTrackable;
    
    protected $table = 'class_discussions';
    
    protected $fillable = [
        'class_id',
        'educator_id',
        'name',
        'class_discussion_message',
        'student_id',
        'message',
        'reply',
        'user_id', // Generic user_id for both educator and student
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Override created_by based on user_id
     */
    public function getCreatedByAttribute()
    {
        return $this->user_id ?? $this->educator_id ?? $this->student_id;
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Generic user relationship for the author of the discussion
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Keep backward compatibility
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Override educator edit permission for discussions
     */
    protected function canEducatorEdit($user): bool
    {
        if (!$user->isEducator()) {
            return false;
        }

        // Educator can edit discussions in their classes or their own discussions
        return $this->class->educator_id === $user->id || $this->user_id === $user->id;
    }
}

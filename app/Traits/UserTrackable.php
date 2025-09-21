<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserTrackable
{
    /**
     * Boot the UserTrackable trait
     */
    protected static function bootUserTrackable()
    {
        // Set created_by when creating
        static::creating(function ($model) {
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });

        // Set updated_by when updating
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });

        // Set deleted_by when soft deleting
        static::deleting(function ($model) {
            if (auth()->check() && method_exists($model, 'trashed') && !$model->trashed()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }

    /**
     * Get the user who created this record
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this record
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted this record
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Scope to filter by creator
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Scope to filter by updater
     */
    public function scopeUpdatedBy($query, $userId)
    {
        return $query->where('updated_by', $userId);
    }

    /**
     * Check if the current user can edit this record
     */
    public function canEdit($user = null): bool
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return false;
        }

        // Admin can edit everything
        if ($user->isAdmin()) {
            return true;
        }

        // Creator can edit their own content
        if ($this->created_by === $user->id) {
            return true;
        }

        // Educator can edit content in their classes (implement per model)
        return $this->canEducatorEdit($user);
    }

    /**
     * Override this method in each model to implement educator-specific edit permissions
     */
    protected function canEducatorEdit($user): bool
    {
        return false;
    }

    /**
     * Check if the current user can delete this record
     */
    public function canDelete($user = null): bool
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return false;
        }

        // Admin can delete everything
        if ($user->isAdmin()) {
            return true;
        }

        // Creator can delete their own content
        if ($this->created_by === $user->id) {
            return true;
        }

        return false;
    }
}
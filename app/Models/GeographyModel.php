<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeographyModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'detailed_description',
        'category',
        'embed_code',
        'educator_id',
        'assigned_classes',
        'is_public',
        'is_active',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'views' => 'integer',
        'assigned_classes' => 'array'
    ];

    /**
     * Get the educator that owns the geography model
     */
    public function educator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get sanitized embed code for safe display
     */
    public function getSafeEmbedCodeAttribute(): string
    {
        // Basic sanitization - only allow iframe and div tags with specific attributes
        $allowedTags = '<iframe><div>';
        return strip_tags($this->embed_code, $allowedTags);
    }

    /**
     * Scope for active models
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for public models
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for models assigned to specific class
     */
    public function scopeForClass($query, $classId)
    {
        return $query->where(function($q) use ($classId) {
            $q->where('is_public', true)
              ->orWhereJsonContains('assigned_classes', $classId);
        });
    }

    /**
     * Check if model is assigned to specific class
     */
    public function isAssignedToClass($classId): bool
    {
        if ($this->is_public) {
            return true;
        }
        
        return in_array($classId, $this->assigned_classes ?? []);
    }

    /**
     * Assign model to classes
     */
    public function assignToClasses(array $classIds): void
    {
        $this->assigned_classes = array_unique(array_merge($this->assigned_classes ?? [], $classIds));
        $this->save();
    }

    /**
     * Remove assignment from classes
     */
    public function removeFromClasses(array $classIds): void
    {
        $this->assigned_classes = array_diff($this->assigned_classes ?? [], $classIds);
        $this->save();
    }

    /**
     * Get assigned classes relationship
     */
    public function assignedClasses()
    {
        return \App\Models\ClassModel::whereIn('id', $this->assigned_classes ?? []);
    }
}

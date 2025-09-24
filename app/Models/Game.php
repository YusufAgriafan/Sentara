<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'game_type',
        'description',
        'thumbnail',
        'settings',
        'difficulty',
        'is_active',
        'is_public',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Get all sessions for this game
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }

    /**
     * Get all achievements for this game
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(GameAchievement::class);
    }

    /**
     * Scope for active games
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for public games
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for specific game type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('game_type', $type);
    }

    /**
     * Get the game's average score
     */
    public function getAverageScoreAttribute()
    {
        return $this->sessions()->where('status', 'completed')->avg('score') ?? 0;
    }

    /**
     * Get total play count
     */
    public function getTotalPlaysAttribute()
    {
        return $this->sessions()->count();
    }

    /**
     * Get game type display name
     */
    public function getGameTypeDisplayAttribute()
    {
        $types = [
            'time_travel' => 'Time Travel Adventure',
            'geography_puzzle' => 'Geography Puzzle',
            'historical_detective' => 'Historical Detective',
            'island_explorer' => 'Island Explorer',
            'memory_palace' => 'Memory Palace',
        ];

        return $types[$this->game_type] ?? $this->game_type;
    }
}
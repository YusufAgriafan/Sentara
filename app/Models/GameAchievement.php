<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'achievement_type',
        'achievement_name',
        'description',
        'achievement_data',
    ];

    protected $casts = [
        'achievement_data' => 'array',
    ];

    /**
     * Get the user that owns this achievement
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game this achievement belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Common achievement types
     */
    public static function getAchievementTypes()
    {
        return [
            'first_completion' => 'First Completion',
            'perfect_score' => 'Perfect Score',
            'speed_run' => 'Speed Run',
            'collector' => 'Collector',
            'explorer' => 'Explorer',
            'detective' => 'Master Detective',
            'historian' => 'History Expert',
            'geographer' => 'Geography Master',
            'memory_master' => 'Memory Master',
        ];
    }

    /**
     * Get achievement icon based on type
     */
    public function getIconAttribute()
    {
        $icons = [
            'first_completion' => '🏁',
            'perfect_score' => '⭐',
            'speed_run' => '⚡',
            'collector' => '📚',
            'explorer' => '🗺️',
            'detective' => '🔍',
            'historian' => '📜',
            'geographer' => '🌍',
            'memory_master' => '🧠',
        ];

        return $icons[$this->achievement_type] ?? '🏆';
    }
}
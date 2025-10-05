<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAI extends Model
{
    use HasFactory;

    protected $table = 'chat_ais';

    protected $fillable = [
        'user_id',
        'role',
        'message',
        'model',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassDiscussion extends Model
{
    use HasFactory;
    protected $table = 'class_discussions';
    protected $fillable = [
        'class_id',
        'educator_id',
        'name',
        'class_discussion_message',
        'student_id',
        'message',
        'reply',
    ];

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
}

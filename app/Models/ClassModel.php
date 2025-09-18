<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $fillable = [
        'name',
        'token',
        'educator_id',
    ];

    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    public function classLists()
    {
        return $this->hasMany(ClassList::class, 'class_id');
    }

    public function discussions()
    {
        return $this->hasMany(ClassDiscussion::class, 'class_id');
    }
}

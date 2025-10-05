<?php

namespace App\Models;

use App\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes, UserTrackable;
    
    protected $table = 'class';
    
    protected $fillable = [
        'name',
        'token',
        'educator_id',
        'grade',
        'subject',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Override created_by to use educator_id for existing functionality
     */
    public function getCreatedByAttribute()
    {
        return $this->educator_id;
    }

    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    // Keep backward compatibility
    public function createdBy()
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

    public function places()
    {
        return $this->belongsToMany(Place::class, 'class_places', 'class_id', 'place_id')
            ->withTimestamps();
    }

    public function stories()
    {
        // Relasi many-to-many langsung dengan stories
        return $this->belongsToMany(Story::class, 'class_stories', 'class_id', 'story_id')
            ->withTimestamps();
    }

    // Helper method untuk mendapatkan semua stories yang tersedia dari places yang terkait dengan class ini
    public function getAvailableStoriesAttribute()
    {
        return Story::whereIn('historical_id', $this->places->pluck('id'))->get();
    }

    // Helper method untuk mendapatkan stories yang sudah di-assign ke class ini
    public function getAssignedStoriesAttribute()
    {
        return $this->stories;
    }

    // Method untuk assign story ke class
    public function assignStory($storyId)
    {
        return $this->stories()->attach($storyId);
    }

    // Method untuk remove story dari class
    public function removeStory($storyId)
    {
        return $this->stories()->detach($storyId);
    }

    // Method untuk sync stories ke class
    public function syncStories($storyIds)
    {
        return $this->stories()->sync($storyIds);
    }

    // Method untuk assign place ke class
    public function assignPlace($placeId)
    {
        return $this->places()->attach($placeId);
    }

    // Method untuk remove place dari class
    public function removePlace($placeId)
    {
        return $this->places()->detach($placeId);
    }

    // Method untuk sync places ke class
    public function syncPlaces($placeIds)
    {
        return $this->places()->sync($placeIds);
    }

    // Method untuk generate token kelas
    public static function generateClassToken()
    {
        do {
            $token = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (self::where('token', $token)->exists());
        
        return $token;
    }

    // Method untuk validate token dan mendapatkan kelas
    public static function findByToken($token)
    {
        return self::where('token', $token)->first();
    }

    // Method untuk check apakah student sudah join kelas ini
    public function hasStudent($studentId)
    {
        return $this->classLists()->where('student_id', $studentId)->exists();
    }

    // Method untuk menambahkan student ke kelas
    public function addStudent($studentId)
    {
        if (!$this->hasStudent($studentId)) {
            return $this->classLists()->create([
                'student_id' => $studentId
            ]);
        }
        return false;
    }

    // Method untuk remove student dari kelas
    public function removeStudent($studentId)
    {
        return $this->classLists()->where('student_id', $studentId)->delete();
    }

    // Method untuk mendapatkan semua students di kelas
    public function getStudents()
    {
        return $this->classLists()->with('student')->get()->pluck('student');
    }

    /**
     * Override educator edit permission for classes
     */
    protected function canEducatorEdit($user): bool
    {
        if (!$user->isEducator()) {
            return false;
        }

        // Only the educator who created the class can edit
        return $this->educator_id === $user->id;
    }
}

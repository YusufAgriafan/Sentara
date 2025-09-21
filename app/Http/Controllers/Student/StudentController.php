<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassList;
use App\Models\Place;
use App\Models\Story;
use App\Models\ClassDiscussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Display student dashboard with class-specific content
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Get current class for this student
        $currentClass = $this->getCurrentClass($user);
        
        $assignedPlaces = collect();
        $assignedStories = collect();
        $activeDiscussions = collect();
        $recentActivities = [];
        $achievements = 0;
        
        if ($currentClass) {
            // Get places assigned to this class
            $assignedPlaces = $currentClass->places()
                ->orderBy('name')
                ->get();
            
            // Get stories assigned to this class
            $assignedStories = $currentClass->stories()
                ->with('place')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Get active discussions for this class
            $activeDiscussions = ClassDiscussion::where('class_id', $currentClass->id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Generate recent activities
            $recentActivities = $this->getRecentActivities($currentClass);
        }
        
        return view('student.dashboard', compact(
            'currentClass',
            'assignedPlaces',
            'assignedStories', 
            'activeDiscussions',
            'recentActivities',
            'achievements'
        ));
    }

    /**
     * Display places assigned to student's class
     */
    public function places(): View|RedirectResponse
    {
        $currentClass = $this->getCurrentClass(Auth::user());
        
        if (!$currentClass) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum terdaftar di kelas manapun');
        }
        
        $places = $currentClass->places()
            ->with('coordinate')
            ->orderBy('name')
            ->get();
            
        return view('student.places.index', compact('places', 'currentClass'));
    }

    /**
     * Display specific place details if assigned to student's class
     */
    public function showPlace(Place $place): View|RedirectResponse
    {
        $currentClass = $this->getCurrentClass(Auth::user());
        
        if (!$currentClass) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum terdaftar di kelas manapun');
        }
        
        // Check if this place is assigned to student's class
        $isAssigned = $currentClass->places()->where('places.id', $place->id)->exists();
        
        if (!$isAssigned) {
            return redirect()->route('student.places')
                ->with('error', 'Tempat ini tidak tersedia untuk kelas Anda');
        }
        
        // Get stories for this place that are assigned to the class
        $stories = $currentClass->stories()
            ->where('historical_id', $place->id)
            ->get();
            
        return view('student.places.show', compact('place', 'stories', 'currentClass'));
    }

    /**
     * Display stories assigned to student's class
     */
    public function stories(): View|RedirectResponse
    {
        $currentClass = $this->getCurrentClass(Auth::user());
        
        if (!$currentClass) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum terdaftar di kelas manapun');
        }
        
        $stories = $currentClass->stories()
            ->with('place')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('student.stories.index', compact('stories', 'currentClass'));
    }

    /**
     * Display specific story if assigned to student's class
     */
    public function showStory(Story $story): View|RedirectResponse
    {
        $currentClass = $this->getCurrentClass(Auth::user());
        
        if (!$currentClass) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum terdaftar di kelas manapun');
        }
        
        // Check if this story is assigned to student's class
        $isAssigned = $currentClass->stories()->where('stories.id', $story->id)->exists();
        
        if (!$isAssigned) {
            return redirect()->route('student.stories')
                ->with('error', 'Cerita ini tidak tersedia untuk kelas Anda');
        }
        
        return view('student.stories.show', compact('story', 'currentClass'));
    }

    /**
     * Join a class using token
     */
    public function joinClass(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string|exists:class,token'
        ]);

        $class = ClassModel::where('token', $request->token)->first();
        
        if (!$class) {
            return redirect()->back()
                ->with('error', 'Token kelas tidak valid');
        }

        // Check if student already in this class
        $existingMembership = ClassList::where('class_id', $class->id)
            ->where('student_id', Auth::id())
            ->exists();

        if ($existingMembership) {
            return redirect()->route('student.dashboard')
                ->with('info', 'Anda sudah terdaftar di kelas ini');
        }

        // Add student to class
        ClassList::create([
            'class_id' => $class->id,
            'student_id' => Auth::id()
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', "Berhasil bergabung dengan kelas {$class->name}");
    }

    /**
     * Get current class for the authenticated user
     */
    private function getCurrentClass($user)
    {
        $classList = ClassList::where('student_id', $user->id)->first();
        return $classList ? $classList->class : null;
    }

    /**
     * Generate recent activities for the class
     */
    private function getRecentActivities($class)
    {
        $activities = [];
        
        // Recent stories
        $recentStories = $class->stories()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        foreach ($recentStories as $story) {
            $activities[] = [
                'type' => 'story',
                'message' => "Cerita baru ditambahkan: {$story->title}",
                'time' => $story->created_at->diffForHumans()
            ];
        }
        
        // Recent places
        $recentPlaces = $class->places()
            ->orderBy('pivot_created_at', 'desc')
            ->take(2)
            ->get();
            
        foreach ($recentPlaces as $place) {
            $activities[] = [
                'type' => 'place',
                'message' => "Tempat wisata baru: {$place->name}",
                'time' => $place->pivot->created_at ?? now()->diffForHumans()
            ];
        }
        
        // Sort by most recent
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 5);
    }
}

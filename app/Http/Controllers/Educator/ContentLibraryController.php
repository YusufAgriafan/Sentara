<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Story;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContentLibraryController extends Controller
{
    /**
     * Display the content library dashboard
     */
    public function index(): View
    {
        $totalPlaces = Place::count();
        $totalStories = Story::count();
        $myClasses = ClassModel::where('educator_id', auth()->id())->count();
        
        // Recent content
        $recentPlaces = Place::with(['coordinate', 'stories'])
            ->latest()
            ->take(6)
            ->get();
            
        $recentStories = Story::with('place')
            ->latest()
            ->take(6)
            ->get();

        return view('educator.content.library.index', compact(
            'totalPlaces', 
            'totalStories', 
            'myClasses',
            'recentPlaces',
            'recentStories'
        ));
    }

    /**
     * Display content assignments overview
     */
    public function assignments(): View
    {
        $classes = ClassModel::where('educator_id', auth()->id())
            ->with(['places.stories'])
            ->get();

        // Statistics per class
        $classStats = $classes->map(function ($class) {
            return [
                'class' => $class,
                'places_count' => $class->places->count(),
                'stories_count' => $class->places->sum(function ($place) {
                    return $place->stories->count();
                }),
                'students_count' => $class->classLists->count()
            ];
        });

        return view('educator.content.assignments.index', compact('classStats'));
    }

    /**
     * Quick assign content to class
     */
    public function quickAssign(Request $request): RedirectResponse
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'place_ids' => 'required|array',
            'place_ids.*' => 'exists:places,id'
        ]);

        $class = ClassModel::findOrFail($request->class_id);
        
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $class->places()->attach($request->place_ids);

        return redirect()->back()->with('success', 'Content berhasil di-assign ke kelas ' . $class->name);
    }
}

<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Place;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    /**
     * Display a listing of stories
     */
    public function index(Request $request): View
    {
        $query = Story::with(['place.coordinate', 'classes']);

        // Filter by era if provided
        if ($request->filled('era')) {
            $query->whereHas('place', function ($q) use ($request) {
                $q->where('era', $request->era);
            });
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('place', function ($placeQuery) use ($search) {
                      $placeQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sort options
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'place':
                $query->join('places', 'stories.historical_id', '=', 'places.id')
                      ->orderBy('places.name', 'asc')
                      ->select('stories.*');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $stories = $query->paginate(12);

        return view('educator.stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new story
     */
    public function create(): View
    {
        $places = Place::orderBy('name')->get();
        return view('educator.stories.create', compact('places'));
    }

    /**
     * Store a newly created story
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'historical_id' => 'required|exists:places,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'illustration' => 'nullable|string|max:255',
        ]);

        Story::create($request->all());

        return redirect()->route('educator.stories.index')
            ->with('success', 'Cerita berhasil ditambahkan');
    }

    /**
     * Display the specified story
     */
    public function show(Story $story): View
    {
        $story->load(['place.coordinate', 'place.classes.educator']);
        
        return view('educator.stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified story
     */
    public function edit(Story $story): View
    {
        $places = Place::orderBy('name')->get();
        return view('educator.stories.edit', compact('story', 'places'));
    }

    /**
     * Update the specified story
     */
    public function update(Request $request, Story $story): RedirectResponse
    {
        $request->validate([
            'historical_id' => 'required|exists:places,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'illustration' => 'nullable|string|max:255',
        ]);

        $story->update($request->all());

        return redirect()->route('educator.stories.index')
            ->with('success', 'Cerita berhasil diperbarui');
    }

    /**
     * Remove the specified story
     */
    public function destroy(Story $story): RedirectResponse
    {
        $story->delete();

        return redirect()->route('educator.stories.index')
            ->with('success', 'Cerita berhasil dihapus');
    }

    /**
     * Get classes for story assignment
     */
    public function getClasses(Story $story)
    {
        $classes = ClassModel::where('educator_id', Auth::id())->get();
        $assignedClasses = $story->classes->pluck('id')->toArray();

        return response()->json([
            'classes' => $classes->map(function($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->name,
                    'grade' => $class->grade ?? 'N/A',
                    'students_count' => $class->classLists->count()
                ];
            }),
            'assignedClasses' => $assignedClasses
        ]);
    }

    /**
     * Assign story to classes
     */
    public function assignClasses(Request $request, Story $story)
    {
        $request->validate([
            'classes' => 'array',
            'classes.*' => 'exists:class,id'
        ]);

        // Verify that all classes belong to the authenticated educator
        $validClasses = ClassModel::whereIn('id', $request->classes ?? [])
            ->where('educator_id', Auth::id())
            ->pluck('id');

        try {
            $story->classes()->sync($validClasses);
            
            $message = count($validClasses) . ' kelas berhasil di-assign ke cerita "' . $story->title . '"';
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error assigning classes'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Place;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentAssignmentController extends Controller
{
    public function index()
    {
        $classes = ClassModel::where('educator_id', Auth::id())
            ->with(['places', 'stories', 'discussions'])
            ->get();
            
        $places = Place::with('classes')->get();
        $stories = Story::with('classes')->get();
        
        // Hitung total assignments
        $assignments = $classes->sum(function($class) {
            return $class->places->count() + $class->stories->count();
        });

        return view('educator.content-assignments.index', compact(
            'classes', 
            'places', 
            'stories', 
            'assignments'
        ));
    }

    // Assign content ke class
    public function assignContent(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'content_type' => 'required|in:places,stories',
            'content_ids' => 'required|array',
            'content_ids.*' => 'required|integer'
        ]);

        $class = ClassModel::where('id', $request->class_id)
            ->where('educator_id', Auth::id())
            ->first();

        if (!$class) {
            return response()->json(['success' => false, 'message' => 'Class not found'], 404);
        }

        try {
            if ($request->content_type === 'places') {
                // Validate places exist
                $validPlaces = Place::whereIn('id', $request->content_ids)->pluck('id');
                $class->places()->syncWithoutDetaching($validPlaces);
                
                $message = count($validPlaces) . ' tempat berhasil di-assign ke kelas';
            } else {
                // Validate stories exist
                $validStories = Story::whereIn('id', $request->content_ids)->pluck('id');
                $class->stories()->syncWithoutDetaching($validStories);
                
                $message = count($validStories) . ' cerita berhasil di-assign ke kelas';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error assigning content'], 500);
        }
    }

    // Bulk assign content ke multiple classes
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'classes' => 'required|array',
            'classes.*' => 'exists:class,id',
            'places' => 'array',
            'places.*' => 'exists:places,id',
            'stories' => 'array', 
            'stories.*' => 'exists:stories,id'
        ]);

        $classes = ClassModel::whereIn('id', $request->classes)
            ->where('educator_id', Auth::id())
            ->get();

        if ($classes->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No valid classes found'], 404);
        }

        try {
            $assignedCount = 0;

            foreach ($classes as $class) {
                // Assign places
                if (!empty($request->places)) {
                    $class->places()->syncWithoutDetaching($request->places);
                    $assignedCount += count($request->places);
                }

                // Assign stories
                if (!empty($request->stories)) {
                    $class->stories()->syncWithoutDetaching($request->stories);
                    $assignedCount += count($request->stories);
                }
            }

            $message = "Bulk assignment berhasil: {$assignedCount} konten di-assign ke " . count($classes) . " kelas";
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error during bulk assignment'], 500);
        }
    }

    // Get class details dengan assigned content
    public function getClassDetails($classId)
    {
        $class = ClassModel::where('id', $classId)
            ->where('educator_id', Auth::id())
            ->with(['places', 'stories', 'discussions'])
            ->first();

        if (!$class) {
            return response()->json(['success' => false, 'message' => 'Class not found'], 404);
        }

        return response()->json([
            'success' => true,
            'class' => [
                'id' => $class->id,
                'name' => $class->name,
                'grade' => $class->grade,
                'subject' => $class->subject,
                'students_count' => $class->classLists->count()
            ],
            'places' => $class->places->map(function($place) {
                return [
                    'id' => $place->id,
                    'name' => $place->name,
                    'location' => $place->location,
                    'era' => $place->era
                ];
            }),
            'stories' => $class->stories->map(function($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'place' => [
                        'name' => $story->place->name
                    ]
                ];
            })
        ]);
    }

    // Remove content assignment dari class
    public function removeAssignment(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'content_type' => 'required|in:places,stories',
            'content_id' => 'required|integer'
        ]);

        $class = ClassModel::where('id', $request->class_id)
            ->where('educator_id', Auth::id())
            ->first();

        if (!$class) {
            return response()->json(['success' => false, 'message' => 'Class not found'], 404);
        }

        try {
            if ($request->content_type === 'places') {
                $class->places()->detach($request->content_id);
                $message = 'Tempat berhasil dihapus dari kelas';
            } else {
                $class->stories()->detach($request->content_id);
                $message = 'Cerita berhasil dihapus dari kelas';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error removing assignment'], 500);
        }
    }

    // Get available content untuk class (yang belum di-assign)
    public function getAvailableContent($classId)
    {
        $class = ClassModel::where('id', $classId)
            ->where('educator_id', Auth::id())
            ->with(['places', 'stories'])
            ->first();

        if (!$class) {
            return response()->json(['success' => false, 'message' => 'Class not found'], 404);
        }

        // Get assigned IDs
        $assignedPlaceIds = $class->places->pluck('id');
        $assignedStoryIds = $class->stories->pluck('id');

        // Get available content
        $availablePlaces = Place::whereNotIn('id', $assignedPlaceIds)->get();
        $availableStories = Story::whereNotIn('id', $assignedStoryIds)->with('place')->get();

        return response()->json([
            'success' => true,
            'available_places' => $availablePlaces->map(function($place) {
                return [
                    'id' => $place->id,
                    'name' => $place->name,
                    'location' => $place->location,
                    'era' => $place->era
                ];
            }),
            'available_stories' => $availableStories->map(function($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'place_name' => $story->place->name
                ];
            })
        ]);
    }
}
<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassList;
use App\Models\Place;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ClassController extends Controller
{
        public function classes(): View
    {
        $classes = ClassModel::where('educator_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('educator.kelas.classes', compact('classes'));
    }

    /**
     * Show the form for creating a new class
     */
    public function createClass(): View
    {
        return view('educator.kelas.create');
    }

    /**
     * Store a newly created class
     */
    public function storeClass(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:100',
        ]);

        $class = ClassModel::create([
            'name' => $request->name,
            'token' => ClassModel::generateClassToken(),
            'educator_id' => auth()->id(),
            'grade' => $request->grade,
            'subject' => $request->subject,
        ]);

        return redirect()->route('educator.classes')
            ->with('success', 'Kelas berhasil dibuat dengan token: ' . $class->token);
    }

    /**
     * Show the form for editing a class
     */
    public function editClass(ClassModel $class): View
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        return view('educator.kelas.edit', compact('class'));
    }

    /**
     * Update the specified class
     */
    public function updateClass(Request $request, ClassModel $class): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class->update([
            'name' => $request->name,
        ]);

        return redirect()->route('educator.classes')
            ->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Generate a new token for the class
     */
    public function regenerateToken(ClassModel $class): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $newToken = Str::random(8);
        $class->update(['token' => $newToken]);

        return redirect()->route('educator.classes')
            ->with('success', 'Token baru berhasil dibuat: ' . $newToken);
    }

    /**
     * Remove the specified class
     */
    public function destroyClass(ClassModel $class): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $class->delete();

        return redirect()->route('educator.classes')
            ->with('success', 'Kelas berhasil dihapus');
    }

    // ========================
    // CONTENT MANAGEMENT METHODS
    // ========================

    /**
     * Show content management for a class
     */
    public function manageContent(ClassModel $class): View
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        // Get all places assigned to this class
        $assignedPlaces = $class->places()->with(['coordinate', 'stories'])->get();
        
        // Get all available places (not assigned to this class)
        $availablePlaces = Place::notInClass($class->id)->with('coordinate')->get();

        return view('educator.kelas.content.index', compact('class', 'assignedPlaces', 'availablePlaces'));
    }

    /**
     * Show form to assign places to class
     */
    public function createContent(ClassModel $class): View
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $availablePlaces = Place::notInClass($class->id)->with(['coordinate', 'stories'])->get();

        return view('educator.kelas.content.create', compact('class', 'availablePlaces'));
    }

    /**
     * Assign places to class
     */
    public function storeContent(Request $request, ClassModel $class): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'place_ids' => 'required|array',
            'place_ids.*' => 'exists:places,id'
        ]);

        // Attach the selected places to the class
        $class->places()->attach($request->place_ids);

        return redirect()->route('educator.classes.content.index', $class)
            ->with('success', 'Konten berhasil ditambahkan ke kelas');
    }

    /**
     * Remove place from class
     */
    public function destroyContent(ClassModel $class, Place $place): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        // Detach the place from the class
        $class->places()->detach($place->id);

        return redirect()->route('educator.classes.content.index', $class)
            ->with('success', 'Konten berhasil dihapus dari kelas');
    }

    /**
     * Bulk assign/sync places to class
     */
    public function syncContent(Request $request, ClassModel $class): RedirectResponse
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'place_ids' => 'array',
            'place_ids.*' => 'exists:places,id'
        ]);

        // Sync places (will remove old assignments and add new ones)
        $class->places()->sync($request->place_ids ?? []);

        return redirect()->route('educator.classes.content.index', $class)
            ->with('success', 'Konten kelas berhasil diperbarui');
    }

    /**
     * Get content data for AJAX requests
     */
    public function getContentData(ClassModel $class)
    {
        // Ensure the class belongs to the current educator
        if ($class->educator_id !== auth()->id()) {
            abort(403);
        }

        $assignedPlaces = $class->places()->with(['coordinate', 'stories'])->get();
        $availablePlaces = Place::notInClass($class->id)->with('coordinate')->get();

        return response()->json([
            'assigned_places' => $assignedPlaces,
            'available_places' => $availablePlaces
        ]);
    }

    /**
     * Show all students from educator's classes
     */
    public function students(Request $request): View
    {
        // Get all classes owned by the current educator
        $educatorClasses = ClassModel::where('educator_id', auth()->id())->pluck('id');
        
        $query = \App\Models\User::where('role', 'student')
            ->whereHas('classList', function($classListQuery) use ($educatorClasses, $request) {
                $classListQuery->whereIn('class_id', $educatorClasses);
                
                // Filter by specific class if provided
                if ($request->filled('class_id')) {
                    $classListQuery->where('class_id', $request->class_id);
                }
            })
            ->with(['classList' => function($query) use ($educatorClasses, $request) {
                $query->whereIn('class_id', $educatorClasses)
                      ->with('class');
                      
                // Filter by specific class if provided
                if ($request->filled('class_id')) {
                    $query->where('class_id', $request->class_id);
                }
            }]);

        // Search by student name if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')->paginate(15);

        // Get educator's classes for filter
        $classes = ClassModel::where('educator_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('educator.students', compact('students', 'classes'));
    }
}

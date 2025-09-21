<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Coordinate;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlaceController extends Controller
{
    /**
     * Display a listing of places
     */
    public function index(Request $request): View
    {
        $query = Place::with(['coordinate', 'stories', 'classes']);

        // Filter by era if provided
        if ($request->filled('era')) {
            $query->where('era', $request->era);
        }

        // Search by name or location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $places = $query->paginate(12);
        
        // Get my classes for quick assignment
        $myClasses = ClassModel::where('educator_id', auth()->id())->get();

        return view('educator.places.index', compact('places', 'myClasses'));
    }

    /**
     * Show the form for creating a new place
     */
    public function create(): View
    {
        return view('educator.places.create');
    }

    /**
     * Store a newly created place
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'era' => 'required|in:prasejarah,kerajaan,penjajahan,kemerdekaan',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Create coordinate first
        $coordinate = Coordinate::create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Create place
        Place::create([
            'name' => $request->name,
            'coordinate_id' => $coordinate->id,
            'location' => $request->location,
            'era' => $request->era,
            'description' => $request->description,
        ]);

        return redirect()->route('educator.places.index')
            ->with('success', 'Tempat berhasil ditambahkan');
    }

    /**
     * Display the specified place
     */
    public function show(Place $place): View
    {
        $place->load(['coordinate', 'stories', 'classes.educator']);
        
        return view('educator.places.show', compact('place'));
    }

    /**
     * Quick assign place to classes
     */
    public function quickAssign(Request $request, Place $place): RedirectResponse
    {
        $request->validate([
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:class,id'
        ]);

        // Verify all classes belong to current educator
        $classes = ClassModel::whereIn('id', $request->class_ids)
            ->where('educator_id', auth()->id())
            ->pluck('id');

        if ($classes->count() !== count($request->class_ids)) {
            return redirect()->back()->with('error', 'Beberapa kelas tidak ditemukan atau bukan milik Anda');
        }

        $place->classes()->syncWithoutDetaching($classes);

        return redirect()->back()->with('success', 'Tempat berhasil di-assign ke kelas yang dipilih');
    }
}

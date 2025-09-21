<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Place;
use App\Models\GeographyModel;
use App\Models\ClassModel;
use App\Models\ClassList;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        return view('main.index');
    }

    public function sejarah()
    {
        return view('main.sejarah');
    }

    public function geografi()
    {
        // Get active geography models for public display
        $geographyModels = \App\Models\GeographyModel::active()
                                                      ->with('educator')
                                                      ->orderBy('views', 'desc')
                                                      ->limit(6)
                                                      ->get();
        
        // Get places for display
        $featuredPlaces = \App\Models\Place::orderBy('created_at', 'desc')
                                           ->limit(6)
                                           ->get();
        
        return view('main.geografi', compact('geographyModels', 'featuredPlaces'));
    }

    public function kelas()
    {
        $user = Auth::user();
        $currentClass = null;
        $availableClasses = collect();
        
        if ($user) {
            // Check jika user sudah join kelas
            $classListEntry = ClassList::where('student_id', $user->id)->with('class')->first();
            
            if ($classListEntry) {
                $currentClass = $classListEntry->class;
            } else {
                // Get available classes jika user belum join
                $availableClasses = ClassModel::where('is_active', true)
                                            ->orderBy('name')
                                            ->get();
            }
        }
        
        return view('main.kelas', compact('user', 'currentClass', 'availableClasses'));
    }

    /**
     * Get geography model embed code for API
     */
    public function getGeographyModelEmbed(GeographyModel $model)
    {
        // Check if user has access to this model
        $user = Auth::user();
        $hasAccess = false;

        if ($model->is_public) {
            $hasAccess = true;
        } elseif ($user && $user->role === 'student') {
            // Check if user is in any of the assigned classes
            $classListEntry = ClassList::where('student_id', $user->id)->first();
            if ($classListEntry && $model->isAssignedToClass($classListEntry->class_id)) {
                $hasAccess = true;
            }
        } elseif ($user && $user->role === 'educator' && $model->educator_id === $user->id) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // Increment view count
        $model->incrementViews();

        return response()->json([
            'id' => $model->id,
            'title' => $model->title,
            'description' => $model->description,
            'detailed_description' => $model->detailed_description,
            'embed_code' => $model->safe_embed_code,
            'category' => $model->category,
            'views' => $model->views,
            'educator' => $model->educator->name,
        ]);
    }
}
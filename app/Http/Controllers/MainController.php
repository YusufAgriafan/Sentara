<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Place;
use App\Models\GeographyModel;
use App\Models\GeographyContent;
use App\Models\ClassModel;
use App\Models\ClassList;
use App\Models\AdminSetting;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        return view('main.index');
    }

    public function sejarah()
    {
        $user = Auth::user();
        $stories = collect();
        $places = collect();
        
        // Get histories data untuk dropdown
        $histories = History::getHierarchy();

        // Check if user is student and has a class
        if ($user && $user->role === 'student') {
            $classListEntry = ClassList::where('student_id', $user->id)->with('class')->first();
            
            if ($classListEntry) {
                $currentClass = $classListEntry->class;
                
                // Get stories assigned to this class
                $assignedStories = $currentClass->stories()->get();
                
                // Get places assigned to this class for historical context
                $assignedPlaces = $currentClass->places()->get();

                // If no content assigned to class and fallback is enabled, use admin fallback
                if ($assignedStories->isEmpty() && AdminSetting::get('content_fallback_enabled', true)) {
                    $fallbackStoryIds = AdminSetting::get('fallback_stories', []);
                    $fallbackPlaceIds = AdminSetting::get('fallback_places', []);

                    if (!empty($fallbackStoryIds)) {
                        $stories = Story::whereIn('id', $fallbackStoryIds)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    }

                    if (!empty($fallbackPlaceIds)) {
                        $places = Place::whereIn('id', $fallbackPlaceIds)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    }
                } else {
                    $stories = $assignedStories;
                    $places = $assignedPlaces;
                }
            }
        } else {
            // For non-students or guests, show all public content
            $stories = Story::orderBy('created_at', 'desc')->limit(6)->get();
            $places = Place::orderBy('created_at', 'desc')->limit(6)->get();
        }

        return view('main.sejarah', compact('stories', 'places', 'histories'));
    }

    public function geografi()
    {
        $user = Auth::user();
        $geographyModels = collect();
        $featuredPlaces = collect();

        // Check if user is student and has a class
        if ($user && $user->role === 'student') {
            $classListEntry = ClassList::where('student_id', $user->id)->with('class')->first();
            
            if ($classListEntry) {
                $currentClass = $classListEntry->class;
                
                // Get geography models assigned to this class
                $assignedGeographyModels = GeographyModel::active()
                    ->where(function($query) use ($currentClass) {
                        $query->where('is_public', true)
                              ->orWhere(function($q) use ($currentClass) {
                                  $q->whereJsonContains('assigned_classes', $currentClass->id);
                              });
                    })
                    ->with('educator')
                    ->orderBy('views', 'desc')
                    ->get();

                // Get places assigned to this class
                $assignedPlaces = $currentClass->places()->get();

                // If no content assigned to class and fallback is enabled, use admin fallback
                if ($assignedGeographyModels->isEmpty() && $assignedPlaces->isEmpty() && AdminSetting::get('content_fallback_enabled', true)) {
                    $fallbackGeographyIds = AdminSetting::get('fallback_geography_models', []);
                    $fallbackPlaceIds = AdminSetting::get('fallback_places', []);

                    if (!empty($fallbackGeographyIds)) {
                        $geographyModels = GeographyModel::active()
                            ->whereIn('id', $fallbackGeographyIds)
                            ->with('educator')
                            ->orderBy('views', 'desc')
                            ->get();
                    }

                    if (!empty($fallbackPlaceIds)) {
                        $featuredPlaces = Place::whereIn('id', $fallbackPlaceIds)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    }
                } else {
                    $geographyModels = $assignedGeographyModels;
                    $featuredPlaces = $assignedPlaces;
                }
            }
        } else {
            // For non-students or guests, show public content
            $geographyModels = GeographyModel::active()
                ->where('is_public', true)
                ->with('educator')
                ->orderBy('views', 'desc')
                ->limit(6)
                ->get();
            
            $featuredPlaces = Place::orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
        }
        
        // Get active geography content for explanations
        $geographyContents = GeographyContent::active()->ordered()->get();
        
        return view('main.geografi', compact('geographyModels', 'featuredPlaces', 'geographyContents'));
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

    /**
     * Show a specific story
     */
    public function showStory(Story $story)
    {
        $user = Auth::user();
        $hasAccess = false;

        // Check if user has access to this story
        if ($user && $user->role === 'student') {
            $classListEntry = ClassList::where('student_id', $user->id)->with('class')->first();
            if ($classListEntry) {
                $currentClass = $classListEntry->class;
                $assignedStories = $currentClass->stories()->pluck('stories.id');
                
                if ($assignedStories->contains($story->id)) {
                    $hasAccess = true;
                } elseif (AdminSetting::get('content_fallback_enabled', true)) {
                    $fallbackStoryIds = AdminSetting::get('fallback_stories', []);
                    if (in_array($story->id, $fallbackStoryIds)) {
                        $hasAccess = true;
                    }
                }
            }
        } else {
            // Non-students can view all stories
            $hasAccess = true;
        }

        if (!$hasAccess) {
            return redirect()->route('sejarah')->with('error', 'You do not have access to this story.');
        }

        return view('main.story', compact('story'));
    }

    /**
     * Get geography content for API
     */
    public function getGeographyContent($slug)
    {
        $content = GeographyContent::where('slug', $slug)
            ->where('is_active', true)
            ->first();
        
        if (!$content) {
            return response()->json([
                'error' => 'Content not found'
            ], 404);
        }
        
        return response()->json([
            'title' => $content->title,
            'content' => $content->content,
            'description' => $content->description,
            'icon' => $content->icon,
            'order_index' => $content->order_index
        ]);
    }
}
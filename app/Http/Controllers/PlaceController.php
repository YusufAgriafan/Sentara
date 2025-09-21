<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Story;

class PlaceController extends Controller
{
    public function index()
    {
        return view('main.sejarah');
    }

    public function getPlacesForMap()
    {
        $places = Place::with(['coordinate', 'stories' => function($query) {
            // Get all stories, ordered by creation date
            $query->orderBy('created_at', 'desc');
        }])->get();
        
        $mapData = $places->map(function ($place) {
            $firstStory = $place->stories->first();
            return [
                'id' => $place->id,
                'name' => $place->name,
                'location' => $place->location,
                'era' => $place->era,
                'description' => $place->description,
                'latitude' => $place->coordinate->latitude,
                'longitude' => $place->coordinate->longitude,
                'has_story' => $place->stories->count() > 0,
                'story_id' => $firstStory ? $firstStory->id : null,
                'story_title' => $firstStory ? $firstStory->title : null,
            ];
        });

        return response()->json($mapData);
    }

    public function getPlacesByEra($era)
    {
        $places = Place::with(['coordinate', 'stories' => function($query) {
                            // Get all stories, ordered by creation date
                            $query->orderBy('created_at', 'desc');
                        }])
                      ->where('era', $era)
                      ->get();
        
        $mapData = $places->map(function ($place) {
            $firstStory = $place->stories->first();
            return [
                'id' => $place->id,
                'name' => $place->name,
                'location' => $place->location,
                'era' => $place->era,
                'description' => $place->description,
                'latitude' => $place->coordinate->latitude,
                'longitude' => $place->coordinate->longitude,
                'has_story' => $place->stories->count() > 0,
                'story_id' => $firstStory ? $firstStory->id : null,
                'story_title' => $firstStory ? $firstStory->title : null,
            ];
        });

        return response()->json($mapData);
    }

    public function showStory($storyId)
    {
        $story = Story::with(['place.coordinate'])
                     ->where('id', $storyId)
                     ->firstOrFail();

        return view('main.story.show', compact('story'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Place;
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
        return view('main.geografi');
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
            }
            
            // Get kelas-kelas yang tersedia untuk ditampilkan (tanpa token untuk security)
            $availableClasses = ClassModel::with(['educator', 'classLists'])
                ->select('id', 'name', 'educator_id', 'grade', 'subject', 'created_at')
                ->get();
        }

        return view('main.kelas', compact('currentClass', 'availableClasses'));
    }

    public function showStory($storyId)
    {
        $story = Story::with(['place.coordinate', 'place.stories'])
                     ->where('id', $storyId)
                     ->firstOrFail();

        return view('main.story.show', compact('story'));
    }
}

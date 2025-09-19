<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducatorController extends Controller
{
    /**
     * Show the educator dashboard
     */
    public function dashboard(): View
    {
        return view('educator.dashboard');
    }

    /**
     * Show the educator classes page
     */
    public function classes(): View
    {
        return view('educator.classes');
    }

    /**
     * Show the educator students page
     */
    public function students(): View
    {
        return view('educator.students');
    }
}

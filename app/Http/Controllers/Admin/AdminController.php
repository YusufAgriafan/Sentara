<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    /**
     * Show the admin users management page
     */
    public function users(): View
    {
        return view('admin.users');
    }

    /**
     * Show the admin settings page
     */
    public function settings(): View
    {
        return view('admin.settings');
    }
}

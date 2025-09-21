<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\GeographyModel;
use App\Models\Place;
use App\Models\Story;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\ClassList;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_educators' => User::where('role', 'educator')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_classes' => ClassModel::count(),
            'total_geography_models' => GeographyModel::count(),
            'total_places' => Place::count(),
            'total_stories' => Story::count(),
            'active_classes' => ClassModel::whereHas('classLists')->count(),
            'recent_users' => User::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        // Recent activities
        $recentGeographyModels = GeographyModel::with('educator')
                                              ->orderBy('created_at', 'desc')
                                              ->limit(5)
                                              ->get();
                                              
        $recentClasses = ClassModel::with('educator')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();

        // Monthly growth statistics
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count(),
                'classes' => ClassModel::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentGeographyModels', 'recentClasses', 'monthlyStats'));
    }

    /**
     * Show the admin users management page
     */
    public function users(Request $request): View
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Status filter (placeholder for future implementation)
        if ($request->filled('status')) {
            // Add status filtering logic here when user status is implemented
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_educators' => User::where('role', 'educator')->count(),
            'total_students' => User::where('role', 'student')->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    /**
     * Show the admin settings page
     */
    public function settings(): View
    {
        $settings = [
            'content_fallback_enabled' => AdminSetting::get('content_fallback_enabled', true),
            'fallback_geography_models' => AdminSetting::get('fallback_geography_models', []),
            'fallback_places' => AdminSetting::get('fallback_places', []),
            'fallback_stories' => AdminSetting::get('fallback_stories', []),
        ];

        // Get available content for fallback selection
        $availableContent = [
            'geography_models' => GeographyModel::where('is_public', true)
                                              ->where('is_active', true)
                                              ->with('educator')
                                              ->get(),
            'places' => Place::all(),
            'stories' => Story::all(),
        ];

        return view('admin.settings', compact('settings', 'availableContent'));
    }

    /**
     * Update content fallback settings
     */
    public function updateContentFallback(Request $request): RedirectResponse
    {
        $request->validate([
            'content_fallback_enabled' => 'boolean',
            'fallback_geography_models' => 'array',
            'fallback_geography_models.*' => 'exists:geography_models,id',
            'fallback_places' => 'array',
            'fallback_places.*' => 'exists:places,id',
            'fallback_stories' => 'array',
            'fallback_stories.*' => 'exists:stories,id',
        ]);

        // Update settings
        AdminSetting::set(
            'content_fallback_enabled',
            $request->boolean('content_fallback_enabled'),
            'boolean',
            'Enable fallback content from admin when class has no assigned content'
        );

        AdminSetting::set(
            'fallback_geography_models',
            $request->input('fallback_geography_models', []),
            'json',
            'Geography models to show as fallback content'
        );

        AdminSetting::set(
            'fallback_places',
            $request->input('fallback_places', []),
            'json',
            'Places to show as fallback content'
        );

        AdminSetting::set(
            'fallback_stories',
            $request->input('fallback_stories', []),
            'json',
            'Stories to show as fallback content'
        );

        return redirect()->route('admin.settings')
                        ->with('success', 'Content fallback settings updated successfully!');
    }

    /**
     * Get content fallback settings for API
     */
    public function getContentFallbackSettings()
    {
        return response()->json([
            'content_fallback_enabled' => AdminSetting::get('content_fallback_enabled', true),
            'fallback_geography_models' => AdminSetting::get('fallback_geography_models', []),
            'fallback_places' => AdminSetting::get('fallback_places', []),
            'fallback_stories' => AdminSetting::get('fallback_stories', []),
        ]);
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,educator,student'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')
                        ->with('success', 'User created successfully!');
    }

    /**
     * Show user details
     */
    public function showUser(User $user): View
    {
        $userStats = [];
        
        if ($user->role === 'educator') {
            $userStats = [
                'total_classes' => $user->teachingClasses()->count(),
                'total_students' => ClassList::whereIn('class_id', $user->teachingClasses()->pluck('id'))->count(),
                'total_geography_models' => GeographyModel::where('educator_id', $user->id)->count(),
                'total_stories' => Story::where('educator_id', $user->id)->count(),
            ];
        } elseif ($user->role === 'student') {
            $classEntry = ClassList::where('student_id', $user->id)->with('class')->first();
            $userStats = [
                'current_class' => $classEntry ? $classEntry->class->name : 'Not enrolled',
                'joined_at' => $classEntry ? $classEntry->created_at : null,
            ];
        }

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,educator,student'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users')
                        ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user): RedirectResponse
    {
        // Prevent deleting the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users')
                            ->with('error', 'Cannot delete the last admin user!');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                            ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users')
                        ->with('success', 'User deleted successfully!');
    }

    /**
     * Bulk actions for users
     */
    public function bulkActionUsers(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,change_role'],
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
            'new_role' => ['required_if:action,change_role', 'in:admin,educator,student'],
        ]);

        $userIds = $request->user_ids;
        $currentUserId = auth()->id();

        // Remove current user from bulk actions
        $userIds = array_filter($userIds, function($id) use ($currentUserId) {
            return $id != $currentUserId;
        });

        if (empty($userIds)) {
            return redirect()->route('admin.users')
                            ->with('error', 'No valid users selected for bulk action!');
        }

        if ($request->action === 'delete') {
            // Prevent deleting all admins
            $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
            $adminIdsToDelete = array_intersect($userIds, $adminIds);
            
            if (count($adminIdsToDelete) >= count($adminIds)) {
                return redirect()->route('admin.users')
                                ->with('error', 'Cannot delete all admin users!');
            }

            User::whereIn('id', $userIds)->delete();
            $message = 'Selected users deleted successfully!';
        } elseif ($request->action === 'change_role') {
            User::whereIn('id', $userIds)->update(['role' => $request->new_role]);
            $message = 'User roles updated successfully!';
        }

        return redirect()->route('admin.users')->with('success', $message);
    }

    /**
     * Content Management - Overview
     */
    public function contentManagement(): View
    {
        // Get paginated content with relationships
        $geographyModels = GeographyModel::with('educator')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'geography_page');
            
        $places = Place::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'places_page');
            
        $stories = Story::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'stories_page');
        
        // Admin content count for fallback
        $adminContentCount = GeographyModel::whereHas('educator', function($q) {
                $q->where('role', 'admin');
            })->where('is_public', true)->count() +
            Place::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })->where('is_public', true)->count() +
            Story::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })->where('is_public', true)->count();

        return view('admin.content', compact(
            'geographyModels', 'places', 'stories', 'adminContentCount'
        ));
    }

    /**
     * Toggle geography model status
     */
    public function toggleGeographyModelStatus(GeographyModel $model): RedirectResponse
    {
        $model->update(['is_active' => !$model->is_active]);
        
        $status = $model->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Geography model {$status} successfully!");
    }

    /**
     * Toggle geography model public status
     */
    public function toggleGeographyModelPublic(GeographyModel $model): RedirectResponse
    {
        $model->update(['is_public' => !$model->is_public]);
        
        $status = $model->is_public ? 'made public' : 'made private';
        return redirect()->back()->with('success', "Geography model {$status} successfully!");
    }

    /**
     * Delete geography model
     */
    public function deleteGeographyModel(GeographyModel $model): RedirectResponse
    {
        $model->delete();
        return redirect()->back()->with('success', 'Geography model deleted successfully!');
    }

    /**
     * Delete story
     */
    public function deleteStory(Story $story): RedirectResponse
    {
        $story->delete();
        return redirect()->back()->with('success', 'Story deleted successfully!');
    }

    /**
     * Delete place
     */
    public function deletePlace(Place $place): RedirectResponse
    {
        $place->delete();
        return redirect()->back()->with('success', 'Place deleted successfully!');
    }

    /**
     * System reports
     */
    public function reports(): View
    {
        // User Growth Data
        $userGrowth = [
            'total' => User::count(),
            'growth' => 0 // Default to 0 for now
        ];
        
        // Users by Role
        $usersByRole = [
            'admin' => User::where('role', 'admin')->count(),
            'educator' => User::where('role', 'educator')->count(),
            'student' => User::where('role', 'student')->count()
        ];
        
        // Content Statistics
        $contentStats = [
            'total' => GeographyModel::count() + Place::count() + Story::count(),
            'public' => GeographyModel::where('is_public', true)->count() + 
                       Place::where('is_public', true)->count() + 
                       Story::where('is_public', true)->count(),
            'admin_content' => GeographyModel::whereHas('educator', function($q) {
                $q->where('role', 'admin');
            })->count() + Place::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })->count() + Story::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })->count(),
            'top_creator' => [
                'name' => 'Admin',
                'count' => GeographyModel::whereHas('educator', function($q) { $q->where('role', 'admin'); })->count()
            ]
        ];
        
        // Activity Summary
        $activitySummary = [
            'recent_users' => User::latest()->take(5)->get(),
            'recent_content' => $this->getRecentContentSimple()
        ];
        
        // System Stats
        $systemStats = [
            'classes' => ClassModel::count(),
            'active_classes' => ClassModel::count(),
            'fallback_enabled' => AdminSetting::get('content_fallback_enabled', 'false') === 'true' ? 1 : 0,
            'avg_content_per_user' => round((GeographyModel::count() + Place::count() + Story::count()) / max(User::count(), 1), 1),
            'daily_active' => 'N/A',
            'weekly_active' => 'N/A',
            'db_size' => 'N/A',
            'storage_used' => 'N/A'
        ];
        
        // Chart Data - Simple version
        $chartData = [
            'userGrowth' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [10, 15, 20, 25, 30, User::count()]
            ],
            'contentDistribution' => [
                'labels' => ['Geography Models', 'Places', 'Stories'],
                'data' => [
                    GeographyModel::count(),
                    Place::count(),
                    Story::count()
                ]
            ]
        ];

        return view('admin.reports', compact(
            'userGrowth', 'usersByRole', 'contentStats', 
            'activitySummary', 'systemStats', 'chartData'
        ));
    }

    private function getUserGrowthReport(): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'month_short' => $date->format('M'),
                'users' => User::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count(),
                'educators' => User::where('role', 'educator')
                                  ->whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)
                                  ->count(),
                'students' => User::where('role', 'student')
                                 ->whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->count(),
            ];
        }
        return $months;
    }

    private function getContentStatsReport(): array
    {
        return [
            'geography_models_by_category' => GeographyModel::selectRaw('category, count(*) as count')
                                                           ->groupBy('category')
                                                           ->get()
                                                           ->pluck('count', 'category')
                                                           ->toArray(),
            'most_viewed_models' => GeographyModel::orderBy('views', 'desc')
                                                 ->limit(10)
                                                 ->get(),
            'educator_content_count' => User::where('role', 'educator')
                                           ->withCount(['teachingClasses'])
                                           ->orderBy('teaching_classes_count', 'desc')
                                           ->limit(10)
                                           ->get(),
        ];
    }

    private function getActivitySummaryReport(): array
    {
        $today = now();
        $yesterday = now()->subDay();
        $lastWeek = now()->subWeek();
        $lastMonth = now()->subMonth();

        return [
            'users_today' => User::whereDate('created_at', $today)->count(),
            'users_yesterday' => User::whereDate('created_at', $yesterday)->count(),
            'users_this_week' => User::where('created_at', '>=', $lastWeek)->count(),
            'users_this_month' => User::where('created_at', '>=', $lastMonth)->count(),
            'classes_this_week' => ClassModel::where('created_at', '>=', $lastWeek)->count(),
            'classes_this_month' => ClassModel::where('created_at', '>=', $lastMonth)->count(),
            'content_this_week' => GeographyModel::where('created_at', '>=', $lastWeek)->count(),
            'content_this_month' => GeographyModel::where('created_at', '>=', $lastMonth)->count(),
        ];
    }

    /**
     * Get recent content for activity summary
     */
    private function getRecentContentSimple(): array
    {
        $recentContent = [];
        
        // Get recent geography models
        $geographyModels = GeographyModel::with('educator')->latest()->take(3)->get();
        foreach ($geographyModels as $model) {
            $recentContent[] = [
                'type' => 'geography',
                'title' => $model->title,
                'creator' => $model->educator->name,
                'created_at' => $model->created_at
            ];
        }
        
        // Get recent places
        $places = Place::with('user')->latest()->take(2)->get();
        foreach ($places as $place) {
            $recentContent[] = [
                'type' => 'place',
                'title' => $place->name,
                'creator' => $place->user->name,
                'created_at' => $place->created_at
            ];
        }
        
        // Get recent stories
        $stories = Story::with('user')->latest()->take(2)->get();
        foreach ($stories as $story) {
            $recentContent[] = [
                'type' => 'story',
                'title' => $story->title,
                'creator' => $story->user->name,
                'created_at' => $story->created_at
            ];
        }
        
        // Sort by created_at desc and take 7
        usort($recentContent, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        
        return array_slice($recentContent, 0, 7);
    }

    /**
     * Display class management page
     */
    public function classes(): View
    {
        $classes = ClassModel::with(['educator', 'classLists.student'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $educators = User::where('role', 'educator')->get();
        
        return view('admin.classes', compact('classes', 'educators'));
    }

    /**
     * Store new class
     */
    public function storeClass(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'educator_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'grade' => 'nullable|integer|min:1|max:12',
            'subject' => 'nullable|string|max:100'
        ]);

        $class = ClassModel::create([
            'name' => $request->name,
            'token' => 'CLASS' . strtoupper(Str::random(8)),
            'educator_id' => $request->educator_id,
            'description' => $request->description,
            'grade' => $request->grade,
            'subject' => $request->subject
        ]);

        return redirect()->route('admin.classes')->with('success', 'Class created successfully.');
    }

    /**
     * Show class details
     */
    public function showClass(ClassModel $class): View
    {
        $class->load(['educator', 'classLists.student']);
        
        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show edit class form
     */
    public function editClass(ClassModel $class): View
    {
        $educators = User::where('role', 'educator')->get();
        
        return view('admin.classes.edit', compact('class', 'educators'));
    }

    /**
     * Update class
     */
    public function updateClass(Request $request, ClassModel $class): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'educator_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'grade' => 'nullable|integer|min:1|max:12',
            'subject' => 'nullable|string|max:100'
        ]);

        $class->update([
            'name' => $request->name,
            'educator_id' => $request->educator_id,
            'description' => $request->description,
            'grade' => $request->grade,
            'subject' => $request->subject
        ]);

        return redirect()->route('admin.classes')->with('success', 'Class updated successfully.');
    }

    /**
     * Delete class
     */
    public function deleteClass(ClassModel $class): RedirectResponse
    {
        try {
            $class->delete();
            return redirect()->route('admin.classes')->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.classes')->with('error', 'Failed to delete class.');
        }
    }
}

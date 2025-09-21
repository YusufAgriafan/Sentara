<?php

use App\Http\Controllers\Educator\ClassController;
use App\Http\Controllers\Educator\ContentLibraryController;
use App\Http\Controllers\Educator\ContentAssignmentController;
use App\Http\Controllers\Educator\PlaceController as EducatorPlaceController;
use App\Http\Controllers\Educator\StoryController;
use App\Http\Controllers\Educator\ClassDiscussionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Educator\EducatorController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\ClassJoinController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/sejarah', [MainController::class, 'sejarah'])->name('sejarah');

// API Routes untuk peta
Route::get('/api/places', [PlaceController::class, 'getPlacesForMap'])->name('api.places');
Route::get('/api/places/era/{era}', [PlaceController::class, 'getPlacesByEra'])->name('api.places.era');

// Public story viewing
Route::get('/story/{story}', [MainController::class, 'showStory'])->name('story.show');

Route::get('/geografi', [MainController::class, 'geografi'])->name('geografi');

Route::get('/kelas', [MainController::class, 'kelas'])->name('kelas');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - only accessible by admin role
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Educator routes - only accessible by educator and admin roles
Route::middleware(['auth', 'verified', 'role:educator,admin'])->prefix('educator')->name('educator.')->group(function () {
    Route::get('/dashboard', [EducatorController::class, 'dashboard'])->name('dashboard');
    
    // Class Management
    Route::get('/classes', [ClassController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [ClassController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [ClassController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}/edit', [ClassController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [ClassController::class, 'updateClass'])->name('classes.update');
    Route::patch('/classes/{class}/regenerate-token', [ClassController::class, 'regenerateToken'])->name('classes.regenerate-token');
    Route::delete('/classes/{class}', [ClassController::class, 'destroyClass'])->name('classes.destroy');
    
    // Content Management for Specific Class (keep existing functionality)
    Route::get('/classes/{class}/content', [ClassController::class, 'manageContent'])->name('classes.content.index');
    Route::get('/classes/{class}/content/create', [ClassController::class, 'createContent'])->name('classes.content.create');
    Route::post('/classes/{class}/content', [ClassController::class, 'storeContent'])->name('classes.content.store');
    Route::delete('/classes/{class}/content/{place}', [ClassController::class, 'destroyContent'])->name('classes.content.destroy');
    Route::put('/classes/{class}/content/sync', [ClassController::class, 'syncContent'])->name('classes.content.sync');
    Route::get('/classes/{class}/content/data', [ClassController::class, 'getContentData'])->name('classes.content.data');
    
    // Content Library (Global Content Management)
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('/library', [ContentLibraryController::class, 'index'])->name('library');
        Route::get('/assignments', [ContentAssignmentController::class, 'index'])->name('assignments');
        Route::post('/assign', [ContentAssignmentController::class, 'assignContent'])->name('assign');
        Route::post('/bulk-assign', [ContentAssignmentController::class, 'bulkAssign'])->name('bulk-assign');
        Route::delete('/remove-assignment', [ContentAssignmentController::class, 'removeAssignment'])->name('remove-assignment');
        Route::get('/class/{class}/details', [ContentAssignmentController::class, 'getClassDetails'])->name('class-details');
        Route::get('/class/{class}/available', [ContentAssignmentController::class, 'getAvailableContent'])->name('available-content');
    });
    
    // Places Management
    Route::prefix('places')->name('places.')->group(function () {
        Route::get('/', [EducatorPlaceController::class, 'index'])->name('index');
        Route::get('/create', [EducatorPlaceController::class, 'create'])->name('create');
        Route::post('/', [EducatorPlaceController::class, 'store'])->name('store');
        Route::get('/{place}', [EducatorPlaceController::class, 'show'])->name('show');
        Route::post('/{place}/quick-assign', [EducatorPlaceController::class, 'quickAssign'])->name('quick-assign');
    });
    
    // Stories Management
    Route::prefix('stories')->name('stories.')->group(function () {
        Route::get('/', [StoryController::class, 'index'])->name('index');
        Route::get('/create', [StoryController::class, 'create'])->name('create');
        Route::post('/', [StoryController::class, 'store'])->name('store');
        Route::get('/{story}', [StoryController::class, 'show'])->name('show');
        Route::get('/{story}/edit', [StoryController::class, 'edit'])->name('edit');
        Route::put('/{story}', [StoryController::class, 'update'])->name('update');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
        
        // Story Assignment Routes
        Route::get('/{story}/classes', [StoryController::class, 'getClasses'])->name('get-classes');
        Route::post('/{story}/assign-classes', [StoryController::class, 'assignClasses'])->name('assign-classes');
    });
    
    // Discussions Management
    Route::prefix('discussions')->name('discussions.')->group(function () {
        Route::get('/', [ClassDiscussionController::class, 'index'])->name('index');
        Route::get('/create', [ClassDiscussionController::class, 'create'])->name('create');
        Route::post('/', [ClassDiscussionController::class, 'store'])->name('store');
        Route::get('/{discussion}', [ClassDiscussionController::class, 'show'])->name('show');
        Route::get('/{discussion}/edit', [ClassDiscussionController::class, 'edit'])->name('edit');
        Route::put('/{discussion}', [ClassDiscussionController::class, 'update'])->name('update');
        Route::delete('/{discussion}', [ClassDiscussionController::class, 'destroy'])->name('destroy');
        Route::post('/{discussion}/reply', [ClassDiscussionController::class, 'reply'])->name('reply');
    });
    
    Route::get('/students', [ClassController::class, 'students'])->name('students');
    
    // Profile routes for educator
    Route::get('/profile', [EducatorController::class, 'profile'])->name('profile');
    Route::patch('/profile', [EducatorController::class, 'updateProfile'])->name('profile.update');
});

// Student routes - only accessible by student role
Route::middleware(['auth', 'verified', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard')->middleware('class.access');
    Route::get('/places', [StudentController::class, 'places'])->name('places')->middleware('class.access');
    Route::get('/places/{place}', [StudentController::class, 'showPlace'])->name('places.show')->middleware('class.access');
    Route::get('/stories', [StudentController::class, 'stories'])->name('stories')->middleware('class.access');
    Route::get('/stories/{story}', [StudentController::class, 'showStory'])->name('stories.show')->middleware('class.access');
    Route::get('/discussions', [StudentController::class, 'discussions'])->name('discussions')->middleware('class.access');
    Route::get('/discussions/{discussion}', [StudentController::class, 'showDiscussion'])->name('discussions.show')->middleware('class.access');
    Route::post('/discussions/{discussion}/reply', [StudentController::class, 'replyDiscussion'])->name('discussions.reply')->middleware('class.access');
    
    // Class joining routes (no middleware needed as they handle the joining process)
    Route::get('/classes/join', [ClassJoinController::class, 'showJoinForm'])->name('classes.join');
    Route::post('/classes/join', [ClassJoinController::class, 'joinClass'])->name('classes.join.submit');
    Route::post('/classes/leave', [ClassJoinController::class, 'leaveClass'])->name('classes.leave');
    Route::get('/classes/details', [ClassJoinController::class, 'showClassDetails'])->name('classes.details')->middleware('class.access');
});

require __DIR__.'/auth.php';

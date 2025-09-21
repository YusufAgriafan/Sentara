<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\GeographyModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EducatorController extends Controller
{
    /**
     * Show the educator dashboard
     */
    public function dashboard(): View
    {
        $geographyModels = GeographyModel::where('educator_id', Auth::id())
                                       ->active()
                                       ->latest()
                                       ->limit(6)
                                       ->get();
        
        // Get educator's classes for assignment options
        $educatorClasses = ClassModel::where('educator_id', Auth::id())
                                   ->orderBy('name')
                                   ->get();
        
        return view('educator.dashboard', compact('geographyModels', 'educatorClasses'));
    }

    /**
     * Show the educator classes page
     */

    /**
     * Show the educator students page
     */
    public function students(): View
    {
        return view('educator.students');
    }

    /**
     * Show the educator profile page
     */
    public function profile(): View
    {
        $user = Auth::user();
        return view('educator.profile', compact('user'));
    }

    /**
     * Update the educator's profile information
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Update name and email
        $user->fill($request->only('name', 'email'));

        // If email was changed, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('educator.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show geography models page
     */
    public function geographyModels(): View
    {
        $geographyModels = GeographyModel::where('educator_id', Auth::id())
                                        ->latest()
                                        ->paginate(12);
        
        return view('educator.geography-models.index', compact('geographyModels'));
    }

    /**
     * Store a new geography model
     */
    public function storeGeographyModel(Request $request): RedirectResponse
    {
        $request->validate([
            'model_title' => 'required|string|max:255',
            'model_description' => 'nullable|string|max:1000',
            'detailed_description' => 'nullable|string',
            'model_category' => 'nullable|string|max:100',
            'embed_code' => 'required|string',
            'assigned_classes' => 'nullable|array',
            'assigned_classes.*' => 'exists:class,id',
            'is_public' => 'boolean',
        ]);

        // Basic validation for embed code (should contain iframe or embed elements)
        if (!str_contains($request->embed_code, '<iframe') && !str_contains($request->embed_code, '<embed')) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['embed_code' => 'Kode embed harus berisi iframe atau embed element.']);
        }

        GeographyModel::create([
            'title' => $request->model_title,
            'description' => $request->model_description,
            'detailed_description' => $request->detailed_description,
            'category' => $request->model_category,
            'embed_code' => $request->embed_code,
            'educator_id' => Auth::id(),
            'assigned_classes' => $request->assigned_classes ?? [],
            'is_public' => $request->boolean('is_public', true),
            'is_active' => true,
        ]);

        return redirect()->route('educator.dashboard')
                       ->with('success', 'Model 3D berhasil ditambahkan!');
    }

    /**
     * Show a specific geography model
     */
    public function showGeographyModel(GeographyModel $model): View
    {
        // Check if the model belongs to the current educator
        if ($model->educator_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this model.');
        }

        $model->incrementViews();
        
        return view('educator.geography-models.show', compact('model'));
    }

    /**
     * Show the edit form for a geography model
     */
    public function editGeographyModel(GeographyModel $model): View
    {
        // Check if the model belongs to the current educator
        if ($model->educator_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this model.');
        }
        
        return view('educator.geography-models.edit', compact('model'));
    }

    /**
     * Update a geography model
     */
    public function updateGeographyModel(Request $request, GeographyModel $model): RedirectResponse
    {
        // Check if the model belongs to the current educator
        if ($model->educator_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this model.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'detailed_description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'embed_code' => 'required|string',
            'assigned_classes' => 'nullable|array',
            'assigned_classes.*' => 'exists:class,id',
            'is_public' => 'boolean',
        ]);

        // Basic validation for embed code
        if (!str_contains($request->embed_code, '<iframe') && !str_contains($request->embed_code, '<embed')) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['embed_code' => 'Kode embed harus berisi iframe atau embed element.']);
        }

        $model->update([
            'title' => $request->title,
            'description' => $request->description,
            'detailed_description' => $request->detailed_description,
            'category' => $request->category,
            'embed_code' => $request->embed_code,
            'assigned_classes' => $request->assigned_classes ?? [],
            'is_public' => $request->boolean('is_public', $model->is_public),
        ]);

        return redirect()->route('educator.geography-models.show', $model)
                       ->with('success', 'Model 3D berhasil diperbarui!');
    }

    /**
     * Delete a geography model
     */
    public function destroyGeographyModel(GeographyModel $model): RedirectResponse
    {
        // Check if the model belongs to the current educator
        if ($model->educator_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this model.');
        }

        $model->delete();

        return redirect()->route('educator.geography-models.index')
                       ->with('success', 'Model 3D berhasil dihapus!');
    }

    /**
     * Toggle geography model status (active/inactive)
     */
    public function toggleGeographyModelStatus(GeographyModel $model): JsonResponse
    {
        // Check if the model belongs to the current educator
        if ($model->educator_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized access to this model.'], 403);
        }

        $model->update(['is_active' => !$model->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $model->is_active,
            'message' => $model->is_active ? 'Model diaktifkan!' : 'Model dinonaktifkan!'
        ]);
    }
}

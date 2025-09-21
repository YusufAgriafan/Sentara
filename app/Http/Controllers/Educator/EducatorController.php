<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
        return view('educator.dashboard');
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
}

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClassJoinController extends Controller
{
    /**
     * Show available classes and join form
     */
    public function showJoinForm(): View
    {
        $user = Auth::user();
        
        // Check jika user sudah join kelas
        $currentClass = ClassList::where('student_id', $user->id)->with('class')->first();
        
        // Get semua kelas yang tersedia (untuk display saja, tidak bisa join langsung)
        $availableClasses = ClassModel::with(['educator', 'classLists'])->get();
        
        return view('main.classes.join', compact('currentClass', 'availableClasses'));
    }

    /**
     * Join class using token
     */
    public function joinClass(Request $request): RedirectResponse
    {
        $request->validate([
            'class_token' => 'required|string|min:6|max:10'
        ], [
            'class_token.required' => 'Token kelas harus diisi',
            'class_token.min' => 'Token kelas minimal 6 karakter',
            'class_token.max' => 'Token kelas maksimal 10 karakter'
        ]);

        $user = Auth::user();
        $token = strtoupper(trim($request->class_token));
        
        // Check jika user sudah join kelas lain
        $existingClass = ClassList::where('student_id', $user->id)->first();
        if ($existingClass) {
            return back()->with('error', 'Anda sudah bergabung dengan kelas lain. Silakan keluar dari kelas sebelumnya terlebih dahulu.');
        }

        // Find kelas berdasarkan token
        $class = ClassModel::findByToken($token);
        
        if (!$class) {
            return back()->with('error', 'Token kelas tidak valid. Pastikan token yang dimasukkan benar.');
        }

        // Check jika sudah join kelas ini (double check)
        if ($class->hasStudent($user->id)) {
            return back()->with('info', 'Anda sudah terdaftar di kelas ini.');
        }

        // Join kelas
        $result = $class->addStudent($user->id);
        
        if ($result) {
            return redirect()->route('student.dashboard')
                ->with('success', "Berhasil bergabung dengan kelas '{$class->name}'!");
        } else {
            return back()->with('error', 'Gagal bergabung dengan kelas. Silakan coba lagi.');
        }
    }

    /**
     * Leave current class
     */
    public function leaveClass(): RedirectResponse
    {
        $user = Auth::user();
        
        $classListEntry = ClassList::where('student_id', $user->id)->first();
        
        if (!$classListEntry) {
            return back()->with('error', 'Anda tidak terdaftar di kelas manapun.');
        }

        $className = $classListEntry->class->name;
        $classListEntry->delete();
        
        // Clear session
        session()->forget('current_class_id');
        
        return redirect()->route('student.classes.join')
            ->with('success', "Berhasil keluar dari kelas '{$className}'.");
    }

    /**
     * Show class details for current class
     */
    public function showClassDetails(): View|RedirectResponse
    {
        $user = Auth::user();
        
        $classListEntry = ClassList::where('student_id', $user->id)->with(['class.educator', 'class.classLists.student'])->first();
        
        if (!$classListEntry) {
            return redirect()->route('student.classes.join')
                ->with('error', 'Anda belum bergabung dengan kelas manapun.');
        }

        $class = $classListEntry->class;
        $classmates = $class->getStudents();
        
        return view('main.classes.details', compact('class', 'classmates'));
    }
}
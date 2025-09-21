<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use App\Models\ClassList;
use Symfony\Component\HttpFoundation\Response;

class ValidateClassAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip jika user bukan student (educator dan admin bisa akses semua)
        if (!Auth::check() || Auth::user()->role !== 'student') {
            return $next($request);
        }

        $user = Auth::user();
        
        // Cek apakah student sudah terdaftar di kelas manapun
        $studentClass = ClassList::where('student_id', $user->id)->first();
        
        if (!$studentClass) {
            return redirect()->route('kelas')
                ->with('error', 'Anda belum bergabung dengan kelas manapun. Silakan masukkan token kelas untuk bergabung.');
        }

        // Set current class di session untuk akses mudah di controller
        session(['current_class_id' => $studentClass->class_id]);
        
        return $next($request);
    }
}
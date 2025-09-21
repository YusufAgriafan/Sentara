<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\ClassList;

class ClassListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students and classes
        $students = User::where('role', 'student')->get();
        $classes = ClassModel::all();

        if ($classes->count() > 0 && $students->count() > 0) {
            // Assign each student to random classes (1-3 classes per student)
            foreach ($students as $student) {
                $randomClasses = $classes->random(rand(1, min(3, $classes->count())));
                
                foreach ($randomClasses as $class) {
                    // Check if student is not already in this class
                    if (!ClassList::where('student_id', $student->id)->where('class_id', $class->id)->exists()) {
                        ClassList::create([
                            'student_id' => $student->id,
                            'class_id' => $class->id,
                        ]);
                    }
                }
            }
        }
    }
}

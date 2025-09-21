<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Str;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get educators
        $educators = User::where('role', 'educator')->get();

        if ($educators->count() > 0) {
            $classNames = [
                'Sejarah Indonesia',
                'Sejarah Dunia',
                'Sejarah Peradaban Islam',
                'Sejarah Asia Tenggara',
                'Sejarah Modern',
                'Arkeologi Indonesia',
                'Budaya Nusantara',
                'Peradaban Kuno'
            ];

            foreach ($classNames as $className) {
                $educator = $educators->random();
                
                ClassModel::create([
                    'name' => $className,
                    'token' => Str::random(8),
                    'educator_id' => $educator->id,
                ]);
            }
        }
    }
}

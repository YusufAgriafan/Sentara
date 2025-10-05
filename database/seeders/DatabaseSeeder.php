<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GameSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleUserSeeder::class,
            ClassSeeder::class,
            ClassListSeeder::class,
            ClassPlacesSeeder::class,
            PlaceSeeder::class,
            GeographyModelSeeder::class,
            // GeographyContentSeeder::class,
            AdminSettingSeeder::class,
            AdminDataSeeder::class,
            GameSeeder::class,
            // EducationalGameSeeder::class,
            HistoricalDetectiveGameSeeder::class,
        ]);
    }
}

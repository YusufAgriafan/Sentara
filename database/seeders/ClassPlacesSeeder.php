<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\Place;
use App\Models\Coordinate;
use App\Models\Story;
use App\Models\User;

class ClassPlacesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Contoh penggunaan: Assign places yang berbeda ke class yang berbeda
        
        // Misal ada 2 class dan beberapa places
        $class1 = ClassModel::where('name', 'Sejarah Indonesia Kelas 10A')->first();
        $class2 = ClassModel::where('name', 'Sejarah Indonesia Kelas 10B')->first();
        
        // Jika class belum ada, buat dummy
        if (!$class1) {
            $educator = User::first();
            $class1 = ClassModel::create([
                'name' => 'Sejarah Indonesia Kelas 10A',
                'token' => 'TOKEN10A',
                'educator_id' => $educator->id ?? 1
            ]);
        }
        
        if (!$class2) {
            $educator = User::first();
            $class2 = ClassModel::create([
                'name' => 'Sejarah Indonesia Kelas 10B', 
                'token' => 'TOKEN10B',
                'educator_id' => $educator->id ?? 1
            ]);
        }
        
        // Create sample coordinates and places
        $coord1 = Coordinate::create(['latitude' => -6.200000, 'longitude' => 106.816666]);
        $coord2 = Coordinate::create(['latitude' => -7.797068, 'longitude' => 110.370529]);
        $coord3 = Coordinate::create(['latitude' => -8.650000, 'longitude' => 115.216667]);
        
        $place1 = Place::create([
            'name' => 'Monas',
            'coordinate_id' => $coord1->id,
            'location' => 'Jakarta',
            'era' => 'kemerdekaan',
            'description' => 'Monumen Nasional Indonesia'
        ]);
        
        $place2 = Place::create([
            'name' => 'Keraton Yogyakarta',
            'coordinate_id' => $coord2->id,
            'location' => 'Yogyakarta', 
            'era' => 'kerajaan',
            'description' => 'Istana Sultan Yogyakarta'
        ]);
        
        $place3 = Place::create([
            'name' => 'Pura Besakih',
            'coordinate_id' => $coord3->id,
            'location' => 'Bali',
            'era' => 'kerajaan', 
            'description' => 'Pura terbesar di Bali'
        ]);
        
        // Create stories for places
        Story::create([
            'historical_id' => $place1->id,
            'title' => 'Sejarah Pembangunan Monas',
            'content' => 'Monas dibangun pada masa pemerintahan Presiden Soekarno...',
            'illustration' => null
        ]);
        
        Story::create([
            'historical_id' => $place2->id,
            'title' => 'Keraton Sebagai Pusat Budaya',
            'content' => 'Keraton Yogyakarta merupakan pusat kebudayaan Jawa...',
            'illustration' => null
        ]);
        
        // Assign places to different classes
        // Class 10A mendapat Monas dan Keraton
        $class1->places()->attach([$place1->id, $place2->id]);
        
        // Class 10B mendapat Keraton dan Pura Besakih
        $class2->places()->attach([$place2->id, $place3->id]);
        
        $this->command->info('Class-Places relationships created successfully!');
        $this->command->info('Class 10A has access to: Monas, Keraton Yogyakarta');
        $this->command->info('Class 10B has access to: Keraton Yogyakarta, Pura Besakih');
    }
}
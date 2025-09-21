<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Coordinate;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample historical places with coordinates
        $places = [
            // Era Kerajaan
            [
                'name' => 'Candi Borobudur',
                'location' => 'Magelang, Jawa Tengah',
                'era' => 'kerajaan',
                'description' => 'Candi Buddha terbesar di dunia yang dibangun pada abad ke-8 dan ke-9 Masehi.',
                'latitude' => -7.6079,
                'longitude' => 110.2038
            ],
            [
                'name' => 'Candi Prambanan',
                'location' => 'Yogyakarta',
                'era' => 'kerajaan',
                'description' => 'Kompleks candi Hindu terbesar di Indonesia yang dibangun pada abad ke-9 Masehi.',
                'latitude' => -7.7520,
                'longitude' => 110.4915
            ],
            [
                'name' => 'Keraton Yogyakarta',
                'location' => 'Yogyakarta',
                'era' => 'kerajaan',
                'description' => 'Istana resmi Kesultanan Ngayogyakarta Hadiningrat.',
                'latitude' => -7.8053,
                'longitude' => 110.3644
            ],
            [
                'name' => 'Keraton Surakarta',
                'location' => 'Solo, Jawa Tengah',
                'era' => 'kerajaan',
                'description' => 'Istana Kesunanan Surakarta yang didirikan tahun 1745.',
                'latitude' => -7.5755,
                'longitude' => 110.8243
            ],
            
            // Era Penjajahan
            [
                'name' => 'Benteng Rotterdam',
                'location' => 'Makassar, Sulawesi Selatan',
                'era' => 'penjajahan',
                'description' => 'Benteng peninggalan VOC yang dibangun pada tahun 1545.',
                'latitude' => -5.1364,
                'longitude' => 119.4075
            ],
            [
                'name' => 'Gedung Sate',
                'location' => 'Bandung, Jawa Barat',
                'era' => 'penjajahan',
                'description' => 'Gedung pemerintahan kolonial Belanda yang dibangun tahun 1920.',
                'latitude' => -6.9024,
                'longitude' => 107.6186
            ],
            [
                'name' => 'Lawang Sewu',
                'location' => 'Semarang, Jawa Tengah',
                'era' => 'penjajahan',
                'description' => 'Gedung bersejarah peninggalan Nederlands-Indische Spoorweg Maatschappij.',
                'latitude' => -6.9837,
                'longitude' => 110.4093
            ],
            
            // Era Kemerdekaan
            [
                'name' => 'Monumen Nasional (Monas)',
                'location' => 'Jakarta',
                'era' => 'kemerdekaan',
                'description' => 'Monumen peringatan perjuangan kemerdekaan Indonesia.',
                'latitude' => -6.1754,
                'longitude' => 106.8272
            ],
            [
                'name' => 'Gedung Joang 45',
                'location' => 'Jakarta',
                'era' => 'kemerdekaan',
                'description' => 'Tempat bersejarah perjuangan kemerdekaan Indonesia.',
                'latitude' => -6.1845,
                'longitude' => 106.8339
            ],
            [
                'name' => 'Museum Perumusan Naskah Proklamasi',
                'location' => 'Jakarta',
                'era' => 'kemerdekaan',
                'description' => 'Tempat perumusan naskah proklamasi kemerdekaan Indonesia.',
                'latitude' => -6.1889,
                'longitude' => 106.8447
            ],
        ];

        foreach ($places as $placeData) {
            // Create coordinate first
            $coordinate = Coordinate::create([
                'latitude' => $placeData['latitude'],
                'longitude' => $placeData['longitude'],
            ]);

            // Create place with coordinate reference
            Place::create([
                'name' => $placeData['name'],
                'location' => $placeData['location'],
                'era' => $placeData['era'],
                'description' => $placeData['description'],
                'coordinate_id' => $coordinate->id,
            ]);
        }
    }
}
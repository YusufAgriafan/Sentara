<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GeographyModel;
use App\Models\Place;
use App\Models\Story;
use App\Models\ClassModel;
use App\Models\AdminSetting;
use App\Models\Coordinate;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@sentara.com'],
            [
                'name' => 'Admin Sentara',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ]
        );

        // Create some educators
        $educators = [];
        for ($i = 1; $i <= 3; $i++) {
            $educators[] = User::firstOrCreate(
                ['email' => "educator{$i}@sentara.com"],
                [
                    'name' => "Educator {$i}",
                    'role' => 'educator',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now()
                ]
            );
        }

        // Create some students
        $students = [];
        for ($i = 1; $i <= 10; $i++) {
            $students[] = User::firstOrCreate(
                ['email' => "student{$i}@sentara.com"],
                [
                    'name' => "Student {$i}",
                    'role' => 'student',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now()
                ]
            );
        }

        // Create classes
        $classes = [];
        foreach ($educators as $index => $educator) {
            $classes[] = ClassModel::firstOrCreate(
                ['name' => "Kelas " . ($index + 7) . " IPS"],
                [
                    'name' => "Kelas " . ($index + 7) . " IPS",
                    'token' => 'KELAS' . ($index + 7) . 'IPS' . rand(1000, 9999),
                    'educator_id' => $educator->id
                ]
            );
        }

        // Create admin geography models (fallback content)
        $adminGeographyModels = [
            [
                'title' => 'Indonesia Administration Map',
                'description' => 'Comprehensive administrative map of Indonesia with provinces and major cities',
                'detailed_description' => 'This model provides a comprehensive view of Indonesia administrative divisions',
                'category' => 'political',
                'embed_code' => '<div>Admin Geography Model 1</div>',
                'is_active' => true,
                'is_public' => true,
                'educator_id' => $admin->id
            ],
            [
                'title' => 'Java Island Geography',
                'description' => 'Detailed geography model of Java Island including mountains and rivers',
                'detailed_description' => 'This model shows the physical geography of Java Island',
                'category' => 'physical',
                'embed_code' => '<div>Admin Geography Model 2</div>',
                'is_active' => true,
                'is_public' => true,
                'educator_id' => $admin->id
            ],
            [
                'title' => 'Sumatra Physical Map',
                'description' => 'Physical geography model of Sumatra with elevation and water bodies',
                'detailed_description' => 'This model displays the physical features of Sumatra',
                'category' => 'physical',
                'embed_code' => '<div>Admin Geography Model 3</div>',
                'is_active' => true,
                'is_public' => false,
                'educator_id' => $admin->id
            ]
        ];

        foreach ($adminGeographyModels as $modelData) {
            GeographyModel::firstOrCreate(
                ['title' => $modelData['title'], 'educator_id' => $admin->id],
                $modelData
            );
        }

        // Create admin places (fallback content)
        $adminPlaces = [
            [
                'name' => 'Borobudur Temple',
                'description' => 'Ancient Buddhist temple complex in Central Java',
                'location' => 'Central Java, Indonesia',
                'era' => 'kerajaan',
                'coordinate_data' => ['latitude' => -7.6079, 'longitude' => 110.2038],
                'created_by' => $admin->id
            ],
            [
                'name' => 'Lake Toba',
                'description' => 'Largest crater lake in the world, located in North Sumatra',
                'location' => 'North Sumatra, Indonesia',
                'era' => 'prasejarah',
                'coordinate_data' => ['latitude' => 2.6845, 'longitude' => 98.8756],
                'created_by' => $admin->id
            ],
            [
                'name' => 'Raja Ampat Islands',
                'description' => 'Archipelago famous for marine biodiversity in West Papua',
                'location' => 'West Papua, Indonesia',
                'era' => 'prasejarah',
                'coordinate_data' => ['latitude' => -0.2380, 'longitude' => 130.5226],
                'created_by' => $admin->id
            ],
            [
                'name' => 'Mount Bromo',
                'description' => 'Active volcano in East Java',
                'location' => 'East Java, Indonesia',
                'era' => 'prasejarah',
                'coordinate_data' => ['latitude' => -7.9425, 'longitude' => 112.9530],
                'created_by' => $admin->id
            ]
        ];

        $createdPlaces = [];
        foreach ($adminPlaces as $placeData) {
            // Create coordinate first
            $coordinate = Coordinate::create($placeData['coordinate_data']);
            
            // Remove coordinate_data and add coordinate_id
            unset($placeData['coordinate_data']);
            $placeData['coordinate_id'] = $coordinate->id;
            
            $createdPlaces[] = Place::firstOrCreate(
                ['name' => $placeData['name'], 'created_by' => $admin->id],
                $placeData
            );
        }

        // Create admin stories (fallback content)
        $adminStories = [
            [
                'title' => 'The Majapahit Empire',
                'content' => 'The Majapahit Empire was a Javanese Hindu-Buddhist thalassocratic empire in Southeast Asia that was based on the island of Java.',
                'illustration' => null,
                'historical_id' => $createdPlaces[0]->id, // Borobudur
                'created_by' => $admin->id
            ],
            [
                'title' => 'Srivijaya Maritime Kingdom',
                'content' => 'Srivijaya was a Buddhist thalassocratic empire based on the island of Sumatra which influenced much of Southeast Asia.',
                'illustration' => null,
                'historical_id' => $createdPlaces[1]->id, // Lake Toba
                'created_by' => $admin->id
            ],
            [
                'title' => 'Dutch Colonial Period',
                'content' => 'The Dutch East India Company colonized much of Indonesia from the 17th to 20th centuries.',
                'illustration' => null,
                'historical_id' => $createdPlaces[2]->id, // Raja Ampat
                'created_by' => $admin->id
            ],
            [
                'title' => 'Indonesian Independence',
                'content' => 'Indonesia declared independence on August 17, 1945, ending centuries of colonial rule.',
                'illustration' => null,
                'historical_id' => $createdPlaces[3]->id, // Mount Bromo
                'created_by' => $admin->id
            ]
        ];

        foreach ($adminStories as $storyData) {
            Story::firstOrCreate(
                ['title' => $storyData['title'], 'created_by' => $admin->id],
                $storyData
            );
        }

        // Create some educator content
        foreach ($educators as $educator) {
            // Geography models
            GeographyModel::firstOrCreate(
                ['title' => "Custom Geography by {$educator->name}", 'educator_id' => $educator->id],
                [
                    'title' => "Custom Geography by {$educator->name}",
                    'description' => "Custom geography model created by {$educator->name}",
                    'category' => 'custom',
                    'embed_code' => "<div>Custom Geography Model by {$educator->name}</div>",
                    'is_active' => true,
                    'is_public' => rand(0, 1),
                    'educator_id' => $educator->id
                ]
            );

            // Places
            $coordinate = Coordinate::create([
                'latitude' => -6.2088 + (rand(-100, 100) / 1000),
                'longitude' => 106.8456 + (rand(-100, 100) / 1000)
            ]);
            
            $place = Place::firstOrCreate(
                ['name' => "Local Place by {$educator->name}", 'created_by' => $educator->id],
                [
                    'name' => "Local Place by {$educator->name}",
                    'description' => "Local place added by {$educator->name}",
                    'location' => "Jakarta Area",
                    'era' => 'kemerdekaan',
                    'coordinate_id' => $coordinate->id,
                    'created_by' => $educator->id
                ]
            );

            // Stories
            Story::firstOrCreate(
                ['title' => "Historical Story by {$educator->name}", 'created_by' => $educator->id],
                [
                    'title' => "Historical Story by {$educator->name}",
                    'content' => "This is a historical story created by {$educator->name} for educational purposes.",
                    'illustration' => null,
                    'historical_id' => $place->id,
                    'created_by' => $educator->id
                ]
            );
        }

        // Create admin settings for content fallback
        AdminSetting::firstOrCreate(
            ['key' => 'content_fallback_enabled'],
            [
                'key' => 'content_fallback_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable admin content fallback when class-specific content is not available'
            ]
        );

        AdminSetting::firstOrCreate(
            ['key' => 'fallback_geography_enabled'],
            [
                'key' => 'fallback_geography_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable admin geography models as fallback content'
            ]
        );

        AdminSetting::firstOrCreate(
            ['key' => 'fallback_stories_enabled'],
            [
                'key' => 'fallback_stories_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable admin stories as fallback content'
            ]
        );

        AdminSetting::firstOrCreate(
            ['key' => 'fallback_places_enabled'],
            [
                'key' => 'fallback_places_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable admin places as fallback content'
            ]
        );

        $this->command->info('Admin data seeded successfully!');
        $this->command->info('Admin login: admin@sentara.com / password123');
        $this->command->info('Educator logins: educator1@sentara.com to educator3@sentara.com / password123');
        $this->command->info('Student logins: student1@sentara.com to student10@sentara.com / password123');
    }
}

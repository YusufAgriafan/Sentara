<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Petualangan Waktu: Kemerdekaan Indonesia',
                'slug' => 'time-travel-adventure',
                'game_type' => 'time_travel',
                'description' => 'Berpetualang melalui waktu dan rasakan momen-momen bersejarah Indonesia. Buat keputusan sebagai tokoh sejarah dan lihat dampaknya terhadap sejarah bangsa.',
                'thumbnail' => '/images/games/time-travel.jpg',
                'settings' => [
                    'total_chapters' => 10,
                    'scenarios' => [
                        'proklamasi_1945',
                        'sumpah_pemuda',
                        'perang_diponegoro',
                        'majapahit_era',
                        'sriwijaya_kingdom'
                    ],
                    'characters' => ['Sukarno', 'Hatta', 'Diponegoro', 'Gajah Mada'],
                ],
                'difficulty' => 'medium',
                'is_active' => true,
                'is_public' => true,
            ],
            [
                'title' => 'Puzzle Peta Nusantara',
                'slug' => 'geography-puzzle',
                'game_type' => 'geography_puzzle',
                'description' => 'Susun potongan-potongan peta Indonesia dan pelajari tentang provinsi, ibukota, dan keunikan setiap daerah.',
                'thumbnail' => '/images/games/geography-puzzle.jpg',
                'settings' => [
                    'levels' => [
                        ['name' => 'Pulau Jawa', 'pieces' => 6, 'time_limit' => 300],
                        ['name' => 'Pulau Sumatera', 'pieces' => 10, 'time_limit' => 450],
                        ['name' => 'Pulau Kalimantan', 'pieces' => 5, 'time_limit' => 360],
                        ['name' => 'Pulau Sulawesi', 'pieces' => 6, 'time_limit' => 420],
                        ['name' => 'Indonesia Timur', 'pieces' => 15, 'time_limit' => 600],
                        ['name' => 'Seluruh Indonesia', 'pieces' => 34, 'time_limit' => 900]
                    ],
                    'hint_system' => true,
                ],
                'difficulty' => 'easy',
                'is_active' => true,
                'is_public' => true,
            ],
            [
                'title' => 'Detektif Sejarah: Misteri Majapahit',
                'slug' => 'historical-detective',
                'game_type' => 'historical_detective',
                'description' => 'Selidiki misteri sejarah dengan mengumpulkan bukti, mewawancarai saksi, dan memecahkan teka-teki masa lalu.',
                'thumbnail' => '/images/games/historical-detective.jpg',
                'settings' => [
                    'cases' => [
                        [
                            'name' => 'Hilangnya Pusaka Majapahit',
                            'era' => 'majapahit',
                            'difficulty' => 'medium',
                            'clues' => 8,
                            'suspects' => 4
                        ],
                        [
                            'name' => 'Rahasia Candi Borobudur',
                            'era' => 'sailendra',
                            'difficulty' => 'hard',
                            'clues' => 12,
                            'suspects' => 6
                        ]
                    ],
                    'evidence_types' => ['artifact', 'document', 'witness', 'location'],
                ],
                'difficulty' => 'hard',
                'is_active' => true,
                'is_public' => true,
            ],
            [
                'title' => 'Penjelajah Nusantara',
                'slug' => 'island-explorer',
                'game_type' => 'island_explorer',
                'description' => 'Jelajahi kepulauan Indonesia, kumpulkan artefak budaya, dan temukan keunikan setiap pulau dalam perjalanan virtual yang menakjubkan.',
                'thumbnail' => '/images/games/island-explorer.jpg',
                'settings' => [
                    'islands' => [
                        [
                            'name' => 'Jawa',
                            'artifacts' => 25,
                            'mini_games' => ['batik_pattern', 'gamelan_rhythm', 'wayang_story'],
                            'cultural_sites' => ['Borobudur', 'Prambanan', 'Keraton Yogya']
                        ],
                        [
                            'name' => 'Bali',
                            'artifacts' => 20,
                            'mini_games' => ['temple_puzzle', 'dance_sequence', 'offering_ritual'],
                            'cultural_sites' => ['Tanah Lot', 'Besakih', 'Ubud']
                        ],
                        [
                            'name' => 'Sumatera',
                            'artifacts' => 30,
                            'mini_games' => ['traditional_house', 'spice_trading', 'lake_toba'],
                            'cultural_sites' => ['Lake Toba', 'Istano Pagaruyung', 'Rumah Gadang']
                        ]
                    ],
                    'collection_goal' => 100,
                ],
                'difficulty' => 'medium',
                'is_active' => true,
                'is_public' => true,
            ],
            [
                'title' => 'Istana Memori Sejarah',
                'slug' => 'memory-palace',
                'game_type' => 'memory_palace',
                'description' => 'Bangun istana memori Anda dan gunakan teknik mnemonic untuk menghafal tokoh sejarah, tanggal penting, dan lokasi bersejarah.',
                'thumbnail' => '/images/games/memory-palace.jpg',
                'settings' => [
                    'palace_rooms' => [
                        'entrance_hall' => 'Tokoh Kemerdekaan',
                        'history_wing' => 'Peristiwa Bersejarah',
                        'geography_hall' => 'Lokasi Bersejarah',
                        'culture_room' => 'Warisan Budaya',
                        'modern_section' => 'Indonesia Modern'
                    ],
                    'memory_techniques' => [
                        'method_of_loci',
                        'acronym_system',
                        'story_method',
                        'image_association'
                    ],
                    'spaced_repetition' => true,
                    'daily_challenges' => true,
                ],
                'difficulty' => 'hard',
                'is_active' => true,
                'is_public' => true,
            ],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['slug' => $game['slug']], 
                $game
            );
        }

        $this->command->info('Educational games have been seeded successfully!');
    }
}

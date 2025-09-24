<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class EducationalGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Petualangan Waktu: Sejarah Nusantara',
                'description' => 'Berpetualang melalui waktu dan alami peristiwa bersejarah Indonesia. Buat keputusan yang akan mempengaruhi jalannya sejarah!',
                'game_type' => 'adventure',
                'time_limit' => 1800, // 30 minutes
                'difficulty_level' => 'medium',
                'is_active' => true,
                'is_public' => true,
                'background_image' => '/images/games/time-travel-bg.jpg',
                'game_data' => [
                    'scenarios' => [
                        [
                            'id' => 'proklamasi',
                            'title' => 'Proklamasi Kemerdekaan',
                            'year' => '1945',
                            'setting' => 'Jakarta, 17 Agustus 1945',
                            'description' => 'Anda berada di rumah Soekarno menjelang proklamasi kemerdekaan Indonesia.',
                            'character' => 'Reporter',
                            'choices' => [
                                [
                                    'text' => 'Sarankan Soekarno untuk mempercepat proklamasi',
                                    'consequence' => 'Proklamasi dilakukan lebih awal, mengejutkan Jepang',
                                    'points' => 100,
                                    'historical_accuracy' => 85
                                ],
                                [
                                    'text' => 'Tunggu persetujuan dari para pemuda',
                                    'consequence' => 'Diskusi berlangsung lebih lama namun lebih demokratis',
                                    'points' => 120,
                                    'historical_accuracy' => 95
                                ]
                            ],
                            'historical_context' => 'Proklamasi kemerdekaan Indonesia merupakan puncak perjuangan bangsa Indonesia untuk meraih kemerdekaan.'
                        ],
                        [
                            'id' => 'majapahit',
                            'title' => 'Kejayaan Majapahit',
                            'year' => '1350',
                            'setting' => 'Trowulan, Jawa Timur',
                            'description' => 'Sebagai penasihat Raja Hayam Wuruk, Anda harus memberikan strategi untuk memperluas wilayah.',
                            'character' => 'Penasihat Kerajaan',
                            'choices' => [
                                [
                                    'text' => 'Fokus pada perdagangan maritim',
                                    'consequence' => 'Majapahit menjadi pusat perdagangan Asia Tenggara',
                                    'points' => 130,
                                    'historical_accuracy' => 90
                                ],
                                [
                                    'text' => 'Perluas wilayah melalui perang',
                                    'consequence' => 'Wilayah bertambah namun ekonomi terbebani',
                                    'points' => 80,
                                    'historical_accuracy' => 70
                                ]
                            ],
                            'historical_context' => 'Majapahit adalah kerajaan Hindu-Buddha terbesar di Nusantara pada abad ke-14.'
                        ],
                        [
                            'id' => 'sumpah-pemuda',
                            'title' => 'Kongres Pemuda',
                            'year' => '1928',
                            'setting' => 'Jakarta, 28 Oktober 1928',
                            'description' => 'Sebagai salah satu delegasi pemuda, Anda harus membantu merumuskan ikrar persatuan.',
                            'character' => 'Aktivis Pemuda',
                            'choices' => [
                                [
                                    'text' => 'Tekankan pentingnya bahasa persatuan',
                                    'consequence' => 'Bahasa Indonesia diterima sebagai bahasa persatuan',
                                    'points' => 110,
                                    'historical_accuracy' => 100
                                ],
                                [
                                    'text' => 'Fokus pada persatuan organisasi pemuda',
                                    'consequence' => 'Berbagai organisasi bersatu dalam semangat nasionalisme',
                                    'points' => 90,
                                    'historical_accuracy' => 85
                                ]
                            ],
                            'historical_context' => 'Sumpah Pemuda menjadi tonggak penting dalam pergerakan kemerdekaan Indonesia.'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Puzzle Geografi Nusantara',
                'description' => 'Susun peta Indonesia dan pelajari keunikan setiap provinsi. Asah kemampuan geografis sambil mengenal kekayaan budaya Nusantara!',
                'game_type' => 'puzzle',
                'time_limit' => 900, // 15 minutes
                'difficulty_level' => 'easy',
                'is_active' => true,
                'is_public' => true,
                'background_image' => '/images/games/geography-puzzle-bg.jpg',
                'game_data' => [
                    'levels' => [
                        [
                            'id' => 1,
                            'name' => 'Pulau Jawa',
                            'difficulty' => 'easy',
                            'pieces' => 6,
                            'provinces' => [
                                'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 
                                'DI Yogyakarta', 'Jawa Timur', 'Banten'
                            ],
                            'facts' => [
                                'Pulau terpadat di dunia dengan lebih dari 140 juta penduduk',
                                'Terdapat 6 provinsi di Pulau Jawa',
                                'Pusat pemerintahan dan ekonomi Indonesia'
                            ]
                        ],
                        [
                            'id' => 2,
                            'name' => 'Pulau Sumatra',
                            'difficulty' => 'medium',
                            'pieces' => 10,
                            'provinces' => [
                                'Aceh', 'Sumatra Utara', 'Sumatra Barat', 'Riau', 
                                'Kepulauan Riau', 'Jambi', 'Sumatra Selatan', 
                                'Bangka Belitung', 'Bengkulu', 'Lampung'
                            ],
                            'facts' => [
                                'Pulau terbesar keenam di dunia',
                                'Terdapat 10 provinsi di Sumatra',
                                'Kaya akan sumber daya alam seperti minyak dan gas'
                            ]
                        ],
                        [
                            'id' => 3,
                            'name' => 'Indonesia Lengkap',
                            'difficulty' => 'hard',
                            'pieces' => 34,
                            'provinces' => [], // All 34 provinces
                            'facts' => [
                                'Indonesia memiliki 34 provinsi',
                                'Terdiri dari 17.508 pulau',
                                'Negara kepulauan terbesar di dunia'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Detektif Sejarah: Misteri Masa Lalu',
                'description' => 'Pecahkan kasus-kasus misterius dalam sejarah Indonesia. Kumpulkan bukti, wawancarai saksi, dan gunakan deduksi untuk mengungkap kebenaran!',
                'game_type' => 'detective',
                'time_limit' => 1200, // 20 minutes
                'difficulty_level' => 'hard',
                'is_active' => true,
                'is_public' => true,
                'background_image' => '/images/games/detective-bg.jpg',
                'game_data' => [
                    'cases' => [
                        [
                            'id' => 'missing-artifact',
                            'title' => 'Hilangnya Prasasti Kuno',
                            'description' => 'Sebuah prasasti bersejarah dari masa Kerajaan Sriwijaya menghilang dari museum. Investigasi dimulai...',
                            'setting' => 'Museum Nasional Jakarta',
                            'required_evidence' => 3,
                            'required_witnesses' => 2,
                            'scene' => [
                                'background' => '/images/scenes/museum.jpg',
                                'evidence' => [
                                    [
                                        'id' => 'footprint',
                                        'name' => 'Jejak Kaki',
                                        'description' => 'Jejak sepatu boot ukuran 42 di dekat vitrin',
                                        'x' => 30,
                                        'y' => 70,
                                        'icon' => 'fa-shoe-prints',
                                        'points' => 100
                                    ],
                                    [
                                        'id' => 'glass',
                                        'name' => 'Pecahan Kaca',
                                        'description' => 'Pecahan kaca vitrin dengan bekas sidik jari',
                                        'x' => 60,
                                        'y' => 40,
                                        'icon' => 'fa-search',
                                        'points' => 120
                                    ]
                                ]
                            ],
                            'witnesses' => [
                                [
                                    'id' => 'guard',
                                    'name' => 'Pak Budi',
                                    'role' => 'Satpam Museum',
                                    'testimony' => 'Saya melihat seseorang berjas hitam di sekitar ruang Sriwijaya kemarin malam.',
                                    'points' => 80
                                ],
                                [
                                    'id' => 'curator',
                                    'name' => 'Dr. Sari',
                                    'role' => 'Kurator Museum',
                                    'testimony' => 'Prasasti itu sangat berharga, pasti ada kolektor yang mengincarnya.',
                                    'points' => 90
                                ]
                            ],
                            'solutions' => [
                                [
                                    'suspect' => 'Kolektor Pribadi',
                                    'motive' => 'Mengambil untuk koleksi pribadi',
                                    'is_correct' => true,
                                    'explanation' => 'Berdasarkan bukti dan kesaksian, kolektor swasta mencuri prasasti untuk koleksi pribadinya.',
                                    'points' => 500
                                ],
                                [
                                    'suspect' => 'Satpam Museum',
                                    'motive' => 'Menjual untuk mendapat uang',
                                    'is_correct' => false,
                                    'explanation' => 'Satpam tidak memiliki akses dan motif yang kuat untuk pencurian ini.',
                                    'points' => 100
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Penjelajah Nusantara',
                'description' => 'Jelajahi kepulauan Indonesia secara virtual! Temukan pulau-pulau eksotis, pelajari budaya lokal, dan kumpulkan artefak budaya.',
                'game_type' => 'explorer',
                'time_limit' => 2400, // 40 minutes
                'difficulty_level' => 'medium',
                'is_active' => true,
                'is_public' => true,
                'background_image' => '/images/games/explorer-bg.jpg',
                'game_data' => [
                    'islands' => [
                        'jawa' => [
                            'name' => 'Pulau Jawa',
                            'description' => 'Pulau terpadat di Indonesia dengan sejarah yang kaya dan beragam budaya.',
                            'culture' => 'Budaya Jawa, Sunda, dan Betawi dengan candi-candi bersejarah seperti Borobudur dan Prambanan',
                            'nature' => 'Gunung berapi aktif, pantai selatan yang indah, dan dataran rendah yang subur',
                            'cuisine' => 'Gudeg Yogyakarta, Rawon Surabaya, Gado-gado Jakarta, Kerak Telor Betawi'
                        ],
                        'sumatra' => [
                            'name' => 'Pulau Sumatra',
                            'description' => 'Pulau terbesar keenam di dunia dengan kekayaan alam yang melimpah.',
                            'culture' => 'Budaya Batak, Minangkabau, Melayu, dan Aceh dengan rumah adat yang unik',
                            'nature' => 'Hutan hujan tropis, Danau Toba yang memukau, dan pantai barat yang eksotis',
                            'cuisine' => 'Rendang Padang, Soto Padang, Gulai Kambing, Mie Aceh yang pedas'
                        ],
                        'bali' => [
                            'name' => 'Pulau Bali',
                            'description' => 'Pulau Dewata dengan budaya Hindu yang unik dan pariwisata yang terkenal.',
                            'culture' => 'Budaya Hindu Bali dengan pura-pura yang indah dan upacara tradisional',
                            'nature' => 'Pantai-pantai eksotis, gunung berapi, dan sawah terasering yang memukau',
                            'cuisine' => 'Ayam Betutu, Sate Lilit, Lawar, Bebek Betutu yang khas Bali'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Istana Memori: Teknik Mengingat Sejarah',
                'description' => 'Gunakan teknik mnemonic dan istana memori untuk menghafal tokoh sejarah, tanggal penting, dan lokasi bersejarah Indonesia.',
                'game_type' => 'memory',
                'time_limit' => 1500, // 25 minutes
                'difficulty_level' => 'medium',
                'is_active' => true,
                'is_public' => true,
                'background_image' => '/images/games/memory-palace-bg.jpg',
                'game_data' => [
                    'historical_data' => [
                        'figures' => [
                            [
                                'id' => 'soekarno',
                                'name' => 'Soekarno',
                                'birth' => '1901',
                                'role' => 'Presiden pertama Indonesia dan Proklamator kemerdekaan',
                                'image' => '👨‍💼',
                                'mnemonic' => 'Suara karno (Soekarno) memproklamasikan kemerdekaan dengan lantang'
                            ],
                            [
                                'id' => 'hatta',
                                'name' => 'Mohammad Hatta',
                                'birth' => '1902',
                                'role' => 'Wakil Presiden pertama Indonesia dan Bapak Koperasi',
                                'image' => '👨‍🎓',
                                'mnemonic' => 'Hatta hati-hati mengelola ekonomi dan koperasi Indonesia'
                            ],
                            [
                                'id' => 'kartini',
                                'name' => 'R.A. Kartini',
                                'birth' => '1879',
                                'role' => 'Pelopor pendidikan wanita dan emansipasi',
                                'image' => '👩‍🏫',
                                'mnemonic' => 'Kartini seperti kartu emas yang membuka pendidikan untuk wanita'
                            ]
                        ],
                        'dates' => [
                            [
                                'id' => 'proklamasi',
                                'date' => '17 Agustus 1945',
                                'event' => 'Proklamasi Kemerdekaan Indonesia',
                                'mnemonic' => 'Tujuh belas Agustus empat lima, Indonesia merdeka sepanjang masa'
                            ],
                            [
                                'id' => 'sumpah-pemuda',
                                'date' => '28 Oktober 1928',
                                'event' => 'Sumpah Pemuda',
                                'mnemonic' => 'Dua delapan Oktober dua delapan, pemuda bersumpah satu bangsa'
                            ]
                        ],
                        'locations' => [
                            [
                                'id' => 'borobudur',
                                'name' => 'Candi Borobudur',
                                'province' => 'Jawa Tengah',
                                'description' => 'Candi Buddha terbesar di dunia, warisan UNESCO',
                                'image' => '🏛️',
                                'mnemonic' => 'Borobudur seperti buro (kantor) budi Buddha yang megah'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($games as $gameData) {
            Game::create($gameData);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class HistoricalDetectiveGameSeeder extends Seeder
{
    public function run()
    {
        Game::where('game_type', 'historical_detective')->update([
            'settings' => [
                'cases' => [
                    [
                        'id' => 1,
                        'era' => 'majapahit',
                        'name' => 'Hilangnya Pusaka Majapahit',
                        'description' => 'Sebuah pusaka berharga dari era Majapahit telah hilang dari museum. Investigasi diperlukan untuk mengungkap kebenaran.',
                        'difficulty' => 'medium',
                        'max_score' => 1000,
                        'time_limit' => 1800, // 30 minutes
                        'locations' => [
                            [
                                'id' => 'museum',
                                'name' => 'Museum Majapahit',
                                'description' => 'Tempat pusaka terakhir kali terlihat',
                                'emoji' => '🏛️',
                                'evidence' => [
                                    [
                                        'id' => 'broken_lock',
                                        'name' => 'Kunci Rusak',
                                        'type' => 'artifact',
                                        'description' => 'Kunci etalase pusaka ditemukan dalam keadaan rusak',
                                        'points' => 50,
                                        'difficulty' => 'easy'
                                    ],
                                    [
                                        'id' => 'security_footage',
                                        'name' => 'Rekaman CCTV',
                                        'type' => 'document',
                                        'description' => 'Rekaman menunjukkan sosok misterius pada tengah malam',
                                        'points' => 100,
                                        'difficulty' => 'medium'
                                    ]
                                ]
                            ],
                            [
                                'id' => 'storage_room',
                                'name' => 'Ruang Penyimpanan',
                                'description' => 'Ruang penyimpanan artefak di basement museum',
                                'emoji' => '📦',
                                'evidence' => [
                                    [
                                        'id' => 'footprints',
                                        'name' => 'Jejak Kaki',
                                        'type' => 'location',
                                        'description' => 'Jejak kaki yang mengarah ke pintu belakang',
                                        'points' => 75,
                                        'difficulty' => 'medium'
                                    ]
                                ]
                            ],
                            [
                                'id' => 'courtyard',
                                'name' => 'Halaman Museum',
                                'description' => 'Area terbuka di sekitar museum',
                                'emoji' => '🌿',
                                'evidence' => [
                                    [
                                        'id' => 'tire_marks',
                                        'name' => 'Bekas Ban',
                                        'type' => 'location',
                                        'description' => 'Bekas ban kendaraan yang terburu-buru',
                                        'points' => 60,
                                        'difficulty' => 'easy'
                                    ]
                                ]
                            ],
                            [
                                'id' => 'archive_room',
                                'name' => 'Ruang Arsip',
                                'description' => 'Ruang yang menyimpan dokumen-dokumen sejarah',
                                'emoji' => '📚',
                                'evidence' => [
                                    [
                                        'id' => 'historical_document',
                                        'name' => 'Dokumen Kuno',
                                        'type' => 'document',
                                        'description' => 'Dokumen yang menjelaskan nilai sejarah pusaka',
                                        'points' => 120,
                                        'difficulty' => 'hard'
                                    ]
                                ]
                            ]
                        ],
                        'suspects' => [
                            [
                                'id' => 'security_guard',
                                'name' => 'Pak Sujono',
                                'role' => 'Penjaga Keamanan',
                                'emoji' => '👮',
                                'description' => 'Penjaga malam yang bertugas saat kejadian',
                                'suspicion_level' => 'low',
                                'questions' => [
                                    [
                                        'id' => 'duty_time',
                                        'question' => 'Jam berapa Anda bertugas malam itu?',
                                        'answers' => [
                                            ['text' => 'Dari jam 10 malam sampai 6 pagi', 'points' => 10, 'correct' => true],
                                            ['text' => 'Saya tidak ingat dengan pasti', 'points' => 0, 'correct' => false],
                                            ['text' => 'Saya tidak bertugas malam itu', 'points' => -10, 'correct' => false]
                                        ]
                                    ],
                                    [
                                        'id' => 'suspicious_activity',
                                        'question' => 'Apakah Anda melihat aktivitas mencurigakan?',
                                        'answers' => [
                                            ['text' => 'Tidak ada yang aneh', 'points' => 0, 'correct' => false],
                                            ['text' => 'Ada suara dari ruang pameran sekitar jam 2 pagi', 'points' => 15, 'correct' => true],
                                            ['text' => 'Saya tertidur, jadi tidak tahu', 'points' => -5, 'correct' => false]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'id' => 'curator',
                                'name' => 'Dr. Widya',
                                'role' => 'Kurator Museum',
                                'emoji' => '👩‍🎓',
                                'description' => 'Ahli sejarah yang mengelola koleksi museum',
                                'suspicion_level' => 'medium',
                                'questions' => [
                                    [
                                        'id' => 'artifact_value',
                                        'question' => 'Seberapa berharga pusaka yang hilang?',
                                        'answers' => [
                                            ['text' => 'Sangat berharga, bernilai miliaran rupiah', 'points' => 15, 'correct' => true],
                                            ['text' => 'Tidak terlalu mahal', 'points' => 0, 'correct' => false],
                                            ['text' => 'Saya tidak tahu nilai pastinya', 'points' => -5, 'correct' => false]
                                        ]
                                    ],
                                    [
                                        'id' => 'recent_visitors',
                                        'question' => 'Siapa saja yang tahu tentang pusaka ini?',
                                        'answers' => [
                                            ['text' => 'Hanya staf museum', 'points' => 5, 'correct' => false],
                                            ['text' => 'Beberapa kolektor pribadi pernah menanyakannya', 'points' => 20, 'correct' => true],
                                            ['text' => 'Semua orang bisa tahu dari katalog', 'points' => 10, 'correct' => false]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'id' => 'collector',
                                'name' => 'Hendra Kusuma',
                                'role' => 'Kolektor Pribadi',
                                'emoji' => '🧔',
                                'description' => 'Pengusaha yang gemar mengkoleksi artefak',
                                'suspicion_level' => 'high',
                                'questions' => [
                                    [
                                        'id' => 'interest_artifact',
                                        'question' => 'Apakah Anda tertarik dengan pusaka Majapahit?',
                                        'answers' => [
                                            ['text' => 'Ya, saya sangat mengagumi seni Majapahit', 'points' => 10, 'correct' => true],
                                            ['text' => 'Tidak, saya lebih suka era Sriwijaya', 'points' => 0, 'correct' => false],
                                            ['text' => 'Saya tidak pernah ke museum itu', 'points' => -10, 'correct' => false]
                                        ]
                                    ],
                                    [
                                        'id' => 'alibi',
                                        'question' => 'Di mana Anda pada malam kejadian?',
                                        'answers' => [
                                            ['text' => 'Di rumah bersama keluarga', 'points' => 5, 'correct' => false],
                                            ['text' => 'Sedang perjalanan bisnis ke luar kota', 'points' => 15, 'correct' => true],
                                            ['text' => 'Saya lupa, sudah lama sekali', 'points' => -5, 'correct' => false]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'id' => 'cleaning_staff',
                                'name' => 'Bu Tari',
                                'role' => 'Petugas Kebersihan',
                                'emoji' => '🧹',
                                'description' => 'Petugas kebersihan yang bekerja pagi hari',
                                'suspicion_level' => 'low',
                                'questions' => [
                                    [
                                        'id' => 'morning_discovery',
                                        'question' => 'Apa yang Anda lihat saat tiba pagi itu?',
                                        'answers' => [
                                            ['text' => 'Semuanya normal seperti biasa', 'points' => 0, 'correct' => false],
                                            ['text' => 'Etalase pusaka terbuka dan kosong', 'points' => 15, 'correct' => true],
                                            ['text' => 'Saya tidak memperhatikan', 'points' => -5, 'correct' => false]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'solution' => [
                            'culprit' => 'collector',
                            'motive' => 'Obsesi terhadap artefak Majapahit untuk koleksi pribadi',
                            'method' => 'Menyuap penjaga keamanan dan menggunakan kunci palsu',
                            'evidence_required' => ['broken_lock', 'security_footage', 'historical_document'],
                            'min_score_to_solve' => 300
                        ]
                    ],
                    [
                        'id' => 2,
                        'era' => 'sailendra',
                        'name' => 'Rahasia Candi Borobudur',
                        'description' => 'Misteri pembangunan Candi Borobudur menyimpan rahasia yang perlu diungkap.',
                        'difficulty' => 'hard',
                        'max_score' => 1500,
                        'time_limit' => 2400, // 40 minutes
                        'locations' => [
                            [
                                'id' => 'main_temple',
                                'name' => 'Candi Utama',
                                'description' => 'Struktur utama Candi Borobudur',
                                'emoji' => '🏛️',
                                'evidence' => [
                                    [
                                        'id' => 'stone_carving',
                                        'name' => 'Ukiran Batu',
                                        'type' => 'artifact',
                                        'description' => 'Ukiran dengan simbol misterius',
                                        'points' => 80,
                                        'difficulty' => 'medium'
                                    ]
                                ]
                            ]
                            // More locations would be added here
                        ],
                        'suspects' => [
                            // Suspects for the second case would be defined here
                        ],
                        'solution' => [
                            'mystery' => 'Candi Borobudur dibangun sebagai mandala tiga dimensi',
                            'evidence_required' => ['stone_carving'],
                            'min_score_to_solve' => 500
                        ]
                    ]
                ],
                'evidence_types' => [
                    'artifact' => ['icon' => '🏺', 'name' => 'Artefak'],
                    'document' => ['icon' => '📜', 'name' => 'Dokumen'],
                    'witness' => ['icon' => '👤', 'name' => 'Kesaksian'],
                    'location' => ['icon' => '📍', 'name' => 'Lokasi']
                ],
                'scoring' => [
                    'evidence_found' => 10,
                    'correct_interview' => 15,
                    'wrong_interview' => -5,
                    'time_bonus_per_minute' => 2,
                    'case_solved' => 500
                ]
            ]
        ]);
    }
}
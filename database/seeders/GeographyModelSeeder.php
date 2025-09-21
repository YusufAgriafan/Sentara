<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GeographyModel;
use App\Models\User;

class GeographyModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first educator user
        $educator = User::where('role', 'educator')->first();
        
        if (!$educator) {
            $this->command->warn('No educator found. Please create an educator user first.');
            return;
        }

        $models = [
            [
                'title' => 'Struktur Dalam Bumi',
                'description' => 'Model 3D interaktif yang menunjukkan lapisan-lapisan bumi dari kerak hingga inti.',
                'detailed_description' => 'Model 3D ini memungkinkan siswa untuk menjelajahi struktur internal bumi secara detail. Siswa dapat melihat kerak bumi, mantel, inti luar, dan inti dalam dengan berbagai materialnya. Model ini dilengkapi dengan animasi pergerakan lempeng tektonik dan penjelasan tentang proses geologis yang terjadi di setiap lapisan.',
                'category' => 'geologi',
                'embed_code' => '<div class="sketchfab-embed-wrapper"><iframe title="Earth Structure" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="100%" height="100%" src="https://sketchfab.com/models/earth-structure"></iframe></div>',
                'educator_id' => $educator->id,
                'is_public' => true,
                'is_active' => true,
                'views' => rand(50, 200),
            ],
            [
                'title' => 'Sistem Tata Surya',
                'description' => 'Eksplorasi planet-planet dalam tata surya dengan model 3D yang dapat dirotasi.',
                'detailed_description' => 'Model tata surya interaktif yang memungkinkan siswa untuk memahami posisi relatif planet-planet, orbit mereka, dan karakteristik unik masing-masing planet. Siswa dapat mengamati pergerakan planet, fase bulan, dan fenomena astronomi lainnya. Model ini juga menjelaskan konsep gravitasi, jarak antar planet, dan zona layak huni.',
                'category' => 'astronomi',
                'embed_code' => '<div class="sketchfab-embed-wrapper"><iframe title="Solar System" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="100%" height="100%" src="https://sketchfab.com/models/solar-system"></iframe></div>',
                'educator_id' => $educator->id,
                'is_public' => true,
                'is_active' => true,
                'views' => rand(30, 150),
            ],
            [
                'title' => 'Gunung Berapi Indonesia',
                'description' => 'Model 3D gunung berapi aktif di Indonesia dengan simulasi letusan.',
                'detailed_description' => 'Model 3D komprehensif tentang gunung berapi di Indonesia, termasuk Gunung Merapi, Krakatau, dan Tambora. Siswa dapat mempelajari struktur gunung berapi, jenis-jenis letusan, bahaya vulkanik, dan dampaknya terhadap lingkungan. Model ini dilengkapi dengan simulasi letusan dan penjelasan tentang sistem peringatan dini.',
                'category' => 'geografi_fisik',
                'embed_code' => '<div class="sketchfab-embed-wrapper"><iframe title="Indonesian Volcanoes" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="100%" height="100%" src="https://sketchfab.com/models/volcano"></iframe></div>',
                'educator_id' => $educator->id,
                'is_public' => true,
                'is_active' => true,
                'views' => rand(80, 250),
            ],
            [
                'title' => 'Siklus Air Global',
                'description' => 'Visualisasi 3D siklus air dari evaporasi hingga presipitasi.',
                'detailed_description' => 'Model interaktif yang menjelaskan siklus air secara global dengan fokus pada kondisi geografis Indonesia. Siswa dapat mengamati proses evaporasi dari laut dan sungai, pembentukan awan, presipitasi, dan aliran air kembali ke laut. Model ini juga menjelaskan pengaruh topografi, iklim, dan aktivitas manusia terhadap siklus air.',
                'category' => 'klimatologi',
                'embed_code' => '<div class="sketchfab-embed-wrapper"><iframe title="Water Cycle" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="100%" height="100%" src="https://sketchfab.com/models/water-cycle"></iframe></div>',
                'educator_id' => $educator->id,
                'is_public' => true,
                'is_active' => true,
                'views' => rand(40, 180),
            ],
            [
                'title' => 'Topografi Nusantara',
                'description' => 'Model relief 3D kepulauan Indonesia dengan detail topografi.',
                'detailed_description' => 'Model topografi detail Indonesia yang menampilkan pegunungan, dataran rendah, lembah, dan cekungan. Siswa dapat mempelajari karakteristik relief setiap pulau, memahami proses pembentukan topografi, dan menganalisis pengaruh topografi terhadap iklim, vegetasi, dan aktivitas manusia. Model ini juga menjelaskan konsep ketinggian, kemiringan lereng, dan bentuk lahan.',
                'category' => 'kartografi',
                'embed_code' => '<div class="sketchfab-embed-wrapper"><iframe title="Indonesia Topography" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share width="100%" height="100%" src="https://sketchfab.com/models/indonesia-topography"></iframe></div>',
                'educator_id' => $educator->id,
                'is_public' => true,
                'is_active' => true,
                'views' => rand(60, 220),
            ],
        ];

        foreach ($models as $model) {
            GeographyModel::create($model);
        }

        $this->command->info('Geography models seeded successfully!');
    }
}

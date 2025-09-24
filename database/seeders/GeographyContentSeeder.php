<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeographyContent;
use Illuminate\Support\Str;

class GeographyContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'title' => 'Letak Geografis Indonesia',
                'content' => '<div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Posisi Strategis Indonesia</h3>
                    <p class="text-gray-700 leading-relaxed">Indonesia terletak di antara dua benua (Asia dan Australia) dan dua samudra (Hindia dan Pasifik). Posisi ini memberikan keuntungan strategis dalam perdagangan internasional dan kekayaan alam yang melimpah.</p>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Batas Wilayah Indonesia:</h4>
                    <ul class="list-disc pl-6 text-gray-700 space-y-1">
                        <li><strong>Utara:</strong> Malaysia, Singapura, Filipina, dan Laut Cina Selatan</li>
                        <li><strong>Selatan:</strong> Australia dan Samudra Hindia</li>
                        <li><strong>Barat:</strong> Samudra Hindia</li>
                        <li><strong>Timur:</strong> Papua Nugini dan Samudra Pasifik</li>
                    </ul>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                        <p class="text-blue-800"><strong>Fakta Menarik:</strong> Indonesia memiliki lebih dari 17.000 pulau yang tersebar dari Sabang sampai Merauke dengan panjang garis pantai mencapai 95.181 km!</p>
                    </div>
                </div>',
                'description' => 'Memahami posisi strategis Indonesia di antara dua benua dan dua samudra',
                'order_index' => 0,
                'icon' => '🗺️',
                'is_active' => true,
            ],
            [
                'title' => 'Iklim Tropis Indonesia',
                'content' => '<div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Karakteristik Iklim Tropis</h3>
                    <p class="text-gray-700 leading-relaxed">Indonesia memiliki iklim tropis dengan ciri-ciri suhu udara yang relatif tinggi sepanjang tahun, kelembaban udara tinggi, dan curah hujan yang melimpah.</p>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Faktor-faktor yang Mempengaruhi Iklim:</h4>
                    <ul class="list-disc pl-6 text-gray-700 space-y-2">
                        <li><strong>Letak Astronomis:</strong> Indonesia berada di sekitar garis khatulistiwa (6°LU - 11°LS)</li>
                        <li><strong>Letak Geografis:</strong> Dikelilingi oleh samudra luas yang mempengaruhi kelembaban</li>
                        <li><strong>Angin Muson:</strong> Angin musiman yang membawa musim hujan dan kemarau</li>
                        <li><strong>Topografi:</strong> Pegunungan dan dataran tinggi mempengaruhi suhu dan curah hujan</li>
                    </ul>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Musim di Indonesia:</h4>
                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                            <h5 class="font-semibold text-green-800">Musim Hujan</h5>
                            <p class="text-green-700 text-sm">Oktober - Maret, curah hujan tinggi, angin muson barat</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-400">
                            <h5 class="font-semibold text-yellow-800">Musim Kemarau</h5>
                            <p class="text-yellow-700 text-sm">April - September, curah hujan rendah, angin muson timur</p>
                        </div>
                    </div>
                </div>',
                'description' => 'Mengenal karakteristik iklim tropis Indonesia dan faktor-faktor yang mempengaruhinya',
                'order_index' => 1,
                'icon' => '🌤️',
                'is_active' => true,
            ],
            [
                'title' => 'Bentuk Muka Bumi Indonesia',
                'content' => '<div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Keragaman Bentang Alam</h3>
                    <p class="text-gray-700 leading-relaxed">Indonesia memiliki bentang alam yang sangat beragam, mulai dari pegunungan tinggi, dataran rendah, pantai, hingga laut dalam. Keragaman ini disebabkan oleh aktivitas tektonik yang intens di wilayah Indonesia.</p>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Jenis-jenis Bentuk Muka Bumi:</h4>
                    
                    <div class="space-y-4">
                        <div class="bg-brown-50 p-4 rounded-lg border-l-4 border-amber-400">
                            <h5 class="font-semibold text-amber-800 mb-2">🏔️ Pegunungan</h5>
                            <p class="text-amber-700 text-sm">Rangkaian Pegunungan Bukit Barisan di Sumatera, Pegunungan Jayawijaya di Papua, dan rangkaian pegunungan vulkanik di Jawa.</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                            <h5 class="font-semibold text-green-800 mb-2">🌾 Dataran Rendah</h5>
                            <p class="text-green-700 text-sm">Dataran rendah Sumatera Timur, Jawa Utara, dan Kalimantan Selatan yang subur untuk pertanian.</p>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                            <h5 class="font-semibold text-blue-800 mb-2">🏖️ Pantai dan Pesisir</h5>
                            <p class="text-blue-700 text-sm">Garis pantai yang panjang dengan berbagai jenis pantai: berpasir, berbatu, berkarang, dan berawa (mangrove).</p>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-400">
                            <h5 class="font-semibold text-purple-800 mb-2">🌋 Gunung Api</h5>
                            <p class="text-purple-700 text-sm">Indonesia berada di Cincin Api Pasifik dengan 127 gunung api aktif yang memberikan tanah vulkanik yang subur.</p>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6">
                        <p class="text-red-800"><strong>Dampak Geologis:</strong> Aktivitas tektonik menyebabkan Indonesia rawan gempa bumi dan tsunami, namun juga menghasilkan tanah yang subur dan kekayaan mineral.</p>
                    </div>
                </div>',
                'description' => 'Mempelajari keragaman bentang alam Indonesia dari pegunungan hingga pantai',
                'order_index' => 2,
                'icon' => '🏔️',
                'is_active' => true,
            ],
            [
                'title' => 'Flora dan Fauna Indonesia',
                'content' => '<div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Keanekaragaman Hayati Indonesia</h3>
                    <p class="text-gray-700 leading-relaxed">Indonesia merupakan negara mega-biodiversitas dengan kekayaan flora dan fauna yang luar biasa. Posisi geografis Indonesia menjadi pertemuan berbagai jenis flora dan fauna dari Asia dan Australia.</p>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Pembagian Flora dan Fauna Berdasarkan Garis Wallace:</h4>
                    
                    <div class="space-y-4">
                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                            <h5 class="font-semibold text-green-800 mb-2">🦏 Fauna Asiatis (Barat)</h5>
                            <p class="text-green-700 text-sm mb-2">Meliputi Sumatera, Jawa, Bali, dan Kalimantan</p>
                            <p class="text-green-700 text-sm"><strong>Contoh:</strong> Harimau Sumatera, Gajah Asia, Orangutan, Badak Jawa, Banteng</p>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <h5 class="font-semibold text-blue-800 mb-2">🦘 Fauna Australis (Timur)</h5>
                            <p class="text-blue-700 text-sm mb-2">Meliputi Papua dan pulau-pulau sekitarnya</p>
                            <p class="text-blue-700 text-sm"><strong>Contoh:</strong> Burung Cenderawasih, Kanguru Pohon, Kasuari, Kuskus</p>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                            <h5 class="font-semibold text-yellow-800 mb-2">🦎 Fauna Peralihan (Tengah)</h5>
                            <p class="text-yellow-700 text-sm mb-2">Meliputi Sulawesi, Nusa Tenggara, dan Maluku</p>
                            <p class="text-yellow-700 text-sm"><strong>Contoh:</strong> Anoa, Babirusa, Komodo, Maleo, Tarsius</p>
                        </div>
                    </div>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Flora Indonesia:</h4>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-emerald-50 rounded-lg">
                            <div class="text-3xl mb-2">🌳</div>
                            <h6 class="font-semibold text-emerald-800">Hutan Hujan Tropis</h6>
                            <p class="text-emerald-700 text-sm">Keanekaragaman pohon tertinggi di dunia</p>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-3xl mb-2">🌺</div>
                            <h6 class="font-semibold text-red-800">Rafflesia</h6>
                            <p class="text-red-700 text-sm">Bunga terbesar di dunia</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-3xl mb-2">🌿</div>
                            <h6 class="font-semibold text-purple-800">Anggrek</h6>
                            <p class="text-purple-700 text-sm">Ribuan spesies anggrek endemik</p>
                        </div>
                    </div>
                </div>',
                'description' => 'Mengenal kekayaan flora dan fauna Indonesia berdasarkan pembagian biogeografi',
                'order_index' => 3,
                'icon' => '🦋',
                'is_active' => true,
            ],
            [
                'title' => 'Sumber Daya Alam Indonesia',
                'content' => '<div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Kekayaan Sumber Daya Alam</h3>
                    <p class="text-gray-700 leading-relaxed">Indonesia dianugerahi kekayaan sumber daya alam yang melimpah, baik yang dapat diperbaharui maupun tidak dapat diperbaharui. Kekayaan ini menjadi modal utama pembangunan ekonomi nasional.</p>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Sumber Daya Alam Tidak Dapat Diperbaharui:</h4>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-gray-400">
                            <h5 class="font-semibold text-gray-800 mb-2">⛽ Minyak dan Gas Bumi</h5>
                            <ul class="text-gray-700 text-sm space-y-1">
                                <li>• Sumatera: Dumai, Siak</li>
                                <li>• Jawa: Cepu, Cilacap</li>
                                <li>• Kalimantan: Balikpapan, Tarakan</li>
                                <li>• Natuna: Gas alam terbesar</li>
                            </ul>
                        </div>
                        
                        <div class="bg-amber-50 p-4 rounded-lg border-l-4 border-amber-400">
                            <h5 class="font-semibold text-amber-800 mb-2">⛏️ Bahan Tambang</h5>
                            <ul class="text-amber-700 text-sm space-y-1">
                                <li>• Emas: Papua (Grasberg)</li>
                                <li>• Tembaga: Papua, Sulawesi</li>
                                <li>• Nikel: Sulawesi, Maluku</li>
                                <li>• Batu bara: Kalimantan, Sumatera</li>
                            </ul>
                        </div>
                    </div>
                    
                    <h4 class="text-lg font-medium text-gray-800 mt-6 mb-2">Sumber Daya Alam Dapat Diperbaharui:</h4>
                    
                    <div class="space-y-4">
                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                            <h5 class="font-semibold text-green-800 mb-2">🌾 Pertanian</h5>
                            <p class="text-green-700 text-sm">Indonesia adalah penghasil padi, kelapa sawit, kopi, teh, karet, dan rempah-rempah terbesar di dunia.</p>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                            <h5 class="font-semibold text-blue-800 mb-2">🐟 Perikanan</h5>
                            <p class="text-blue-700 text-sm">Dengan laut teritorial 5,8 juta km², Indonesia memiliki potensi ikan laut dan budidaya yang besar.</p>
                        </div>
                        
                        <div class="bg-brown-50 p-4 rounded-lg border-l-4 border-yellow-600">
                            <h5 class="font-semibold text-yellow-800 mb-2">🌲 Kehutanan</h5>
                            <p class="text-yellow-700 text-sm">Hutan tropis Indonesia menghasilkan kayu, rotan, damar, dan berbagai hasil hutan non-kayu.</p>
                        </div>
                    </div>
                    
                    <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mt-6">
                        <p class="text-orange-800"><strong>Tantangan:</strong> Pengelolaan SDA harus berkelanjutan agar dapat dimanfaatkan oleh generasi mendatang tanpa merusak lingkungan.</p>
                    </div>
                </div>',
                'description' => 'Memahami potensi dan sebaran sumber daya alam Indonesia yang melimpah',
                'order_index' => 4,
                'icon' => '💎',
                'is_active' => true,
            ],
        ];

        foreach ($contents as $contentData) {
            $contentData['slug'] = Str::slug($contentData['title']);
            GeographyContent::create($contentData);
        }
    }
}
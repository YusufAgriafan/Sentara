@extends('layouts.main')

@section('title', 'Sejarah Indonesia')

@section('content')
    <!-- Hero Section for Sejarah -->
    <section class="pt-32 pb-24 px-6 lg:px-8 bg-primary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">📚</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Jelajahi <span class="text-secondary">Sejarah</span> Indonesia
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Temukan cerita-cerita menarik dari masa lalu yang membentuk Indonesia hari ini. Dari kerajaan kuno hingga perjuangan kemerdekaan!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('stories')" class="bg-white hover:bg-secondary text-primary px-10 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-book-open mr-3"></i>
                        Mulai Membaca
                    </button>
                    <button onclick="scrollToMap()" class="bg-tertiary hover:bg-tertiary/90 text-gray-900 px-10 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105">
                        <i class="fas fa-map-marked-alt mr-3"></i>
                        Lihat Peta
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive History Content Section -->
    <section id="history-content" class="py-24 px-6 lg:px-8 bg-quaternary">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Eksplorasi Sejarah Indonesia 🔍</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Pilih topik sejarah untuk mempelajari lebih dalam</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-10 lg:p-16 border border-gray-200">
                <!-- Dropdown Navigation -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    <div>
                        <label for="category-select" class="block text-sm font-bold text-gray-700 mb-3">Kategori</label>
                        <select id="category-select" class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary bg-quaternary text-lg">
                            <option value="">Pilih Kategori</option>
                            @foreach($histories as $category => $categoryData)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="subcategory-select" class="block text-sm font-bold text-gray-700 mb-3">Sub Kategori</label>
                        <select id="subcategory-select" class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary bg-quaternary text-lg">
                            <option value="">Pilih Sub Kategori</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="subsubcategory-select" class="block text-sm font-bold text-gray-700 mb-3">Detail</label>
                        <select id="subsubcategory-select" class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary bg-quaternary text-lg">
                            <option value="">Pilih Detail</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button id="reset-btn" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-2xl transition duration-300 font-bold">
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Content Display Area -->
                <div id="content-display" class="mt-8">
                    <div id="welcome-message" class="text-center py-16">
                        <div class="text-8xl mb-6">📖</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di Perpustakaan Sejarah</h3>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                            Pilih kategori di atas untuk mulai menjelajahi berbagai topik sejarah Indonesia yang menarik dan penuh makna.
                        </p>
                    </div>
                    
                    <div id="history-content-area" class="hidden">
                        <div class="bg-gray-50 rounded-2xl p-8">
                            <div id="content-breadcrumb" class="text-sm text-gray-500 mb-4"></div>
                            <h3 id="content-title" class="text-2xl font-bold text-gray-900 mb-6"></h3>
                            <div id="content-body" class="prose max-w-none text-gray-700 leading-relaxed"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section id="timeline" class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Timeline Sejarah Indonesia 📅</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Perjalanan panjang bangsa Indonesia dari masa ke masa</p>
            </div>
            
            <div class="space-y-20">
                <!-- Era Prasejarah -->
                <div class="fade-in-up">
                    <div class="bg-secondary rounded-3xl p-10 lg:p-16 border border-tertiary">
                        <div class="grid lg:grid-cols-2 gap-16 items-center">
                            <div>
                                <div class="text-8xl mb-8">🦕</div>
                                <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-8">Prasejarah Indonesia</h3>
                                <p class="text-xl text-gray-700 leading-relaxed mb-8">
                                    Masa sebelum ada tulisan di Indonesia, dimulai dari kehidupan manusia purba hingga berkembangnya kebudayaan megalitik yang meninggalkan warisan berupa candi-candi dan alat-alat batu.
                                </p>
                                <div class="flex items-center space-x-6 font-bold">
                                    <span class="bg-tertiary text-gray-900 px-6 py-3 rounded-full text-lg">2 Juta - 400 SM</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-3xl p-10 shadow-lg border border-gray-200">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6">Periode Penting:</h4>
                                <ul class="space-y-4 text-gray-700">
                                    <li class="flex items-center text-lg"><i class="fas fa-bone text-primary mr-4 text-xl"></i>Manusia Purba (2 juta tahun lalu)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-fire text-primary mr-4 text-xl"></i>Zaman Batu (500.000 - 2.500 SM)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-hammer text-primary mr-4 text-xl"></i>Zaman Perunggu (2.500 - 500 SM)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-mountain text-primary mr-4 text-xl"></i>Kebudayaan Megalitik (2.500 SM - 400 M)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Era Kerajaan -->
                <div class="fade-in-up">
                    <div class="bg-tertiary rounded-3xl p-10 lg:p-16 border border-gray-300">
                        <div class="grid lg:grid-cols-2 gap-16 items-center">
                            <div>
                                <div class="text-8xl mb-8">👑</div>
                                <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-8">Era Kerajaan</h3>
                                <p class="text-xl text-gray-700 leading-relaxed mb-8">
                                    Masa kejayaan kerajaan-kerajaan besar Nusantara yang menguasai perdagangan maritim dan menyebarkan pengaruh politik, budaya, serta agama ke seluruh Asia Tenggara.
                                </p>
                                <div class="flex items-center space-x-6 font-bold">
                                    <span class="bg-primary text-white px-6 py-3 rounded-full text-lg">7-16 Abad Masehi</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-3xl p-10 shadow-lg border border-gray-200">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6">Kerajaan Terkenal:</h4>
                                <ul class="space-y-4 text-gray-700">
                                    <li class="flex items-center text-lg"><i class="fas fa-crown text-primary mr-4 text-xl"></i>Kerajaan Kutai (400-1635 M)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-crown text-primary mr-4 text-xl"></i>Kerajaan Sriwijaya (671-1377 M)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-crown text-primary mr-4 text-xl"></i>Kerajaan Majapahit (1293-1527 M)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-crown text-primary mr-4 text-xl"></i>Kesultanan Demak (1475-1554 M)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-crown text-primary mr-4 text-xl"></i>Kesultanan Mataram (1586-1755 M)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Era Kolonial -->
                <div class="fade-in-up">
                    <div class="bg-quaternary rounded-3xl p-10 lg:p-16 border border-gray-300">
                        <div class="grid lg:grid-cols-2 gap-16 items-center">
                            <div class="lg:order-2">
                                <div class="text-8xl mb-8">⚔️</div>
                                <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-8">Era Penjajahan</h3>
                                <p class="text-xl text-gray-700 leading-relaxed mb-8">
                                    Periode penjajahan oleh bangsa Eropa yang mengubah struktur politik, ekonomi, dan sosial budaya masyarakat Indonesia. Era ini melahirkan semangat nasionalisme dan perlawanan rakyat.
                                </p>
                                <div class="flex items-center space-x-6 font-bold">
                                    <span class="bg-red-500 text-white px-6 py-3 rounded-full text-lg">1602-1945</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-3xl p-10 shadow-lg lg:order-1 border border-gray-200">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6">Periode Penting:</h4>
                                <ul class="space-y-4 text-gray-700">
                                    <li class="flex items-center text-lg"><i class="fas fa-ship text-red-500 mr-4 text-xl"></i>Kedatangan Portugis (1512)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-building text-red-500 mr-4 text-xl"></i>VOC (1602-1799)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-flag text-red-500 mr-4 text-xl"></i>Hindia Belanda (1800-1942)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-exclamation-triangle text-red-500 mr-4 text-xl"></i>Pendudukan Jepang (1942-1945)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-fist-raised text-red-500 mr-4 text-xl"></i>Pergerakan Nasional (1908-1945)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Era Kemerdekaan -->
                <div class="fade-in-up">
                    <div class="bg-secondary rounded-3xl p-10 lg:p-16 border border-tertiary">
                        <div class="grid lg:grid-cols-2 gap-16 items-center">
                            <div>
                                <div class="text-8xl mb-8">🇮🇩</div>
                                <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-8">Era Kemerdekaan</h3>
                                <p class="text-xl text-gray-700 leading-relaxed mb-8">
                                    Masa perjuangan mempertahankan kemerdekaan dan membangun bangsa Indonesia yang merdeka, bersatu, dan berdaulat. Era pembangunan nasional dan transformasi Indonesia menjadi negara modern.
                                </p>
                                <div class="flex items-center space-x-6 font-bold">
                                    <span class="bg-green-500 text-white px-6 py-3 rounded-full text-lg">1945-Sekarang</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-3xl p-10 shadow-lg border border-gray-200">
                                <h4 class="text-2xl font-bold text-gray-900 mb-6">Momen Bersejarah:</h4>
                                <ul class="space-y-4 text-gray-700">
                                    <li class="flex items-center text-lg"><i class="fas fa-calendar-day text-green-500 mr-4 text-xl"></i>Proklamasi 17 Agustus 1945</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-sword text-green-500 mr-4 text-xl"></i>Revolusi Fisik (1945-1949)</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-handshake text-green-500 mr-4 text-xl"></i>Pengakuan Kedaulatan 1949</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-vote-yea text-green-500 mr-4 text-xl"></i>Era Reformasi 1998</li>
                                    <li class="flex items-center text-lg"><i class="fas fa-building text-green-500 mr-4 text-xl"></i>Indonesia Modern (1998-Sekarang)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Stories Section -->
    <section id="stories" class="py-24 px-6 lg:px-8 bg-quaternary">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Cerita Sejarah Trending! 🔥</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Baca cerita-cerita seru yang lagi viral di kalangan anak muda!</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                @if(isset($stories) && $stories->isNotEmpty())
                    @foreach($stories as $index => $story)
                        <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200" style="animation-delay: {{ $index * 0.2 }}s;">
                            <div class="text-6xl mb-8">📚</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $story->title }}</h3>
                            <div class="prose prose-lg text-gray-600 leading-relaxed mb-8">
                                {!! \Illuminate\Support\Str::markdown(Str::limit($story->content, 120)) !!}
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="bg-tertiary text-gray-900 px-4 py-2 rounded-full text-sm font-bold">Cerita</span>
                                <a href="{{ route('story.show', $story) }}" class="text-primary hover:text-primary/80 font-bold">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default/Fallback Static Stories -->
                    <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200">
                        <div class="text-6xl mb-8">📚</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Ratu Kalinyamat: Wonder Woman Jawa</h3>
                        <div class="prose prose-lg text-gray-600 leading-relaxed mb-8">
                            {!! \Illuminate\Support\Str::markdown('Kisah seorang ratu yang memimpin armada laut melawan Portugis. Keren banget kan?') !!}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="bg-tertiary text-gray-900 px-4 py-2 rounded-full text-sm font-bold">Trending</span>
                            <button class="text-primary hover:text-primary/80 font-bold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200" style="animation-delay: 0.2s;">
                        <div class="text-6xl mb-8">⚔️</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Pangeran Diponegoro: Rebel with a Cause</h3>
                        <div class="prose prose-lg text-gray-600 leading-relaxed mb-8">
                            {!! \Illuminate\Support\Str::markdown('Perjuangan seorang pangeran yang menentang kolonial demi rakyatnya. Inspiratif!') !!}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="bg-secondary text-gray-900 px-4 py-2 rounded-full text-sm font-bold">Popular</span>
                            <button class="text-primary hover:text-primary/80 font-bold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200" style="animation-delay: 0.4s;">
                        <div class="text-6xl mb-8">🚢</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Laksamana Cheng Ho: Admiral dari Tiongkok</h3>
                        <div class="prose prose-lg text-gray-600 leading-relaxed mb-8">
                            {!! \Illuminate\Support\Str::markdown('Petualangan laksamana legendaris yang menjelajahi Nusantara. Epic!') !!}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="bg-primary text-white px-4 py-2 rounded-full text-sm font-bold">Epic</span>
                            <button class="text-primary hover:text-primary/80 font-bold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Interactive Learning Section -->
    <section class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Peta Sejarah Indonesia! 🗺️</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Jelajahi lokasi bersejarah Indonesia dalam peta interaktif!</p>
            </div>
            
            <!-- Map Container -->
            <div class="fade-in-up mb-16">
                <div class="bg-quaternary rounded-3xl p-10 shadow-xl border border-gray-200">
                    <!-- Era Filter Buttons -->
                    <div class="flex flex-wrap justify-center gap-4 mb-10">
                        <button id="btn-all" class="era-filter-btn bg-primary text-white px-6 py-4 lg:px-8 lg:py-4 rounded-3xl font-bold transition-all duration-300 hover:scale-105 active text-sm lg:text-base">
                            <i class="fas fa-globe mr-2 lg:mr-3"></i>Semua Era
                        </button>
                        <button id="btn-prasejarah" class="era-filter-btn bg-white text-gray-700 px-6 py-4 lg:px-8 lg:py-4 rounded-3xl font-bold transition-all duration-300 hover:scale-105 text-sm lg:text-base border border-gray-300">
                            <i class="fas fa-bone mr-2 lg:mr-3"></i>Prasejarah
                        </button>
                        <button id="btn-kerajaan" class="era-filter-btn bg-white text-gray-700 px-6 py-4 lg:px-8 lg:py-4 rounded-3xl font-bold transition-all duration-300 hover:scale-105 text-sm lg:text-base border border-gray-300">
                            <i class="fas fa-crown mr-2 lg:mr-3"></i>Era Kerajaan
                        </button>
                        <button id="btn-penjajahan" class="era-filter-btn bg-white text-gray-700 px-6 py-4 lg:px-8 lg:py-4 rounded-3xl font-bold transition-all duration-300 hover:scale-105 text-sm lg:text-base border border-gray-300">
                            <i class="fas fa-ship mr-2 lg:mr-3"></i>Era Penjajahan
                        </button>
                        <button id="btn-kemerdekaan" class="era-filter-btn bg-white text-gray-700 px-6 py-4 lg:px-8 lg:py-4 rounded-3xl font-bold transition-all duration-300 hover:scale-105 text-sm lg:text-base border border-gray-300">
                            <i class="fas fa-flag mr-2 lg:mr-3"></i>Era Kemerdekaan
                        </button>
                    </div>
                    
                    <!-- Map -->
                    <div id="map" class="w-full h-96 lg:h-[500px] rounded-3xl shadow-lg border border-gray-300"></div>
                    
                    <!-- Map Legend -->
                    <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div class="flex items-center justify-center space-x-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-200">
                            <div class="w-5 h-5 bg-green-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-bold text-sm lg:text-base">Prasejarah</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-200">
                            <div class="w-5 h-5 bg-yellow-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-bold text-sm lg:text-base">Era Kerajaan</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-200">
                            <div class="w-5 h-5 bg-red-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-bold text-sm lg:text-base">Era Penjajahan</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-200">
                            <div class="w-5 h-5 bg-blue-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-bold text-sm lg:text-base">Era Kemerdekaan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Initialize map
    let map;
    let markersLayer;
    
    // Color mapping for different eras
    const eraColors = {
        'prasejarah': '#10b981', // green-500
        'kerajaan': '#eab308', // yellow-500
        'penjajahan': '#ef4444', // red-500  
        'kemerdekaan': '#3b82f6' // blue-500
    };
    
    // Initialize the map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeMap();
        loadAllPlaces();
        setupFilterButtons();
    });
    
    function initializeMap() {
        // Initialize map centered on Indonesia
        map = L.map('map').setView([-2.5, 118.0], 5);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);
        
        // Initialize markers layer group
        markersLayer = L.layerGroup().addTo(map);
        
        // Handle responsive map sizing
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
        
        // Handle window resize
        window.addEventListener('resize', () => {
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        });
    }
    
    function loadAllPlaces() {
        fetch('/api/places')
            .then(response => response.json())
            .then(places => {
                displayPlacesOnMap(places);
            })
            .catch(error => {
                console.error('Error loading places:', error);
            });
    }
    
    function loadPlacesByEra(era) {
        const url = era === 'all' ? '/api/places' : `/api/places/era/${era}`;
        
        fetch(url)
            .then(response => response.json())
            .then(places => {
                displayPlacesOnMap(places);
            })
            .catch(error => {
                console.error('Error loading places by era:', error);
            });
    }
    
    function displayPlacesOnMap(places) {
        // Clear existing markers
        markersLayer.clearLayers();
        
        places.forEach(place => {
            const color = eraColors[place.era] || '#6b7280'; // default gray
            
            // Create custom icon
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
            
            // Create marker
            const marker = L.marker([place.latitude, place.longitude], {
                icon: customIcon
            });
            
            // Create popup content
            const popupContent = `
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-2">${place.name}</h3>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt mr-1"></i>${place.location}</p>
                    <p class="text-sm text-gray-700 mb-3">${place.description || 'Lokasi bersejarah Indonesia'}</p>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                            Era ${place.era.charAt(0).toUpperCase() + place.era.slice(1)}
                        </span>
                        ${place.has_story ? 
                            `<button onclick="readStory(${place.story_id})" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                Baca Cerita <i class="fas fa-book-open ml-1"></i>
                            </button>` :
                            `<span class="text-gray-400 text-sm">Belum ada cerita</span>`
                        }
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent, {
                maxWidth: 300,
                className: 'custom-popup'
            });
            
            markersLayer.addLayer(marker);
        });
    }
    
    function setupFilterButtons() {
        const filterButtons = document.querySelectorAll('.era-filter-btn');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white', 'active');
                    btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-300');
                });
                
                // Add active class to clicked button
                this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-300');
                this.classList.add('bg-primary', 'text-white', 'active');
                
                // Get era from button id
                const era = this.id.replace('btn-', '');
                
                // Load places for selected era
                loadPlacesByEra(era);
            });
        });
    }
    
    function readStory(storyId) {
        // Redirect to the story page
        window.location.href = `/story/${storyId}`;
    }
    
    function learnMore(placeId) {
        // This function can be expanded to show more details about the place
        alert(`Fitur detail untuk lokasi ID ${placeId} akan segera hadir!`);
    }
    
    // Smooth scroll to map section
    function scrollToMap() {
        document.getElementById('map').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }

    // History dropdown functionality
    const historiesData = @json($histories);
    
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category-select');
        const subcategorySelect = document.getElementById('subcategory-select');
        const subsubcategorySelect = document.getElementById('subsubcategory-select');
        const resetBtn = document.getElementById('reset-btn');
        const welcomeMessage = document.getElementById('welcome-message');
        const historyContentArea = document.getElementById('history-content-area');
        const contentBreadcrumb = document.getElementById('content-breadcrumb');
        const contentTitle = document.getElementById('content-title');
        const contentBody = document.getElementById('content-body');

        function updateSubcategories() {
            const selectedCategory = categorySelect.value;
            subcategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
            subsubcategorySelect.innerHTML = '<option value="">Pilih Detail</option>';
            
            if (selectedCategory && historiesData[selectedCategory]) {
                Object.keys(historiesData[selectedCategory]).forEach(subcategory => {
                    if (subcategory) {
                        const option = document.createElement('option');
                        option.value = subcategory;
                        option.textContent = subcategory;
                        subcategorySelect.appendChild(option);
                    }
                });
            }
        }

        function updateSubSubcategories() {
            const selectedCategory = categorySelect.value;
            const selectedSubcategory = subcategorySelect.value;
            subsubcategorySelect.innerHTML = '<option value="">Pilih Detail</option>';
            
            if (selectedCategory && selectedSubcategory && historiesData[selectedCategory][selectedSubcategory]) {
                Object.keys(historiesData[selectedCategory][selectedSubcategory]).forEach(subsubcategory => {
                    if (subsubcategory) {
                        const option = document.createElement('option');
                        option.value = subsubcategory;
                        option.textContent = subsubcategory;
                        subsubcategorySelect.appendChild(option);
                    }
                });
            }
        }

        function displayContent() {
            const selectedCategory = categorySelect.value;
            const selectedSubcategory = subcategorySelect.value;
            const selectedSubSubcategory = subsubcategorySelect.value;
            
            let content = null;
            let breadcrumb = [];
            
            if (selectedCategory) {
                breadcrumb.push(selectedCategory);
                
                if (selectedSubcategory) {
                    breadcrumb.push(selectedSubcategory);
                    
                    if (selectedSubSubcategory) {
                        breadcrumb.push(selectedSubSubcategory);
                        
                        // Get content from sub-subcategory
                        const data = historiesData[selectedCategory][selectedSubcategory][selectedSubSubcategory];
                        if (data && data[0]) {
                            content = data[0];
                        }
                    } else {
                        // Get content from subcategory (first item without sub-subcategory)
                        const data = historiesData[selectedCategory][selectedSubcategory][''];
                        if (data && data[0]) {
                            content = data[0];
                        }
                    }
                } else {
                    // Get content from category (first item without subcategory)
                    const data = historiesData[selectedCategory][''];
                    if (data && data[0]) {
                        content = data[0];
                    }
                }
                
                if (content) {
                    welcomeMessage.classList.add('hidden');
                    historyContentArea.classList.remove('hidden');
                    
                    contentBreadcrumb.textContent = breadcrumb.join(' › ');
                    contentTitle.textContent = content.title;
                    contentBody.innerHTML = content.content || '<p class="text-gray-500 italic">Konten belum tersedia</p>';
                } else {
                    resetDisplay();
                }
            } else {
                resetDisplay();
            }
        }

        function resetDisplay() {
            welcomeMessage.classList.remove('hidden');
            historyContentArea.classList.add('hidden');
        }

        function resetDropdowns() {
            categorySelect.value = '';
            subcategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
            subsubcategorySelect.innerHTML = '<option value="">Pilih Detail</option>';
            resetDisplay();
        }

        // Event listeners
        categorySelect.addEventListener('change', function() {
            updateSubcategories();
            displayContent();
        });

        subcategorySelect.addEventListener('change', function() {
            updateSubSubcategories();
            displayContent();
        });

        subsubcategorySelect.addEventListener('change', displayContent);
        
        resetBtn.addEventListener('click', resetDropdowns);
    });
</script>

<style>
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 0;
    }
    
    .custom-popup .leaflet-popup-tip {
        background: white;
    }
    
    .custom-popup .leaflet-popup-content {
        margin: 0;
        min-width: 250px;
    }
    
    .era-filter-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    #map {
        z-index: 1;
    }
    
    .custom-marker {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }
    
    @media (max-width: 768px) {
        .era-filter-btn {
            font-size: 14px;
            padding: 8px 12px;
        }
        
        .custom-popup .leaflet-popup-content {
            min-width: 200px;
        }
    }
</style>
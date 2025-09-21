@extends('layouts.main')

@section('title', 'Sejarah Indonesia')

@section('content')
    <!-- Hero Section for Sejarah -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-br from-primary to-secondary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">📚</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Jelajahi <span class="text-quaternary">Sejarah</span> Indonesia
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Temukan cerita-cerita menarik dari masa lalu yang membentuk Indonesia hari ini. Dari kerajaan kuno hingga perjuangan kemerdekaan!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('stories')" class="bg-white hover:bg-gray-100 text-primary px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-book-open mr-3"></i>
                        Mulai Membaca
                    </button>
                    <button onclick="scrollToMap()" class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 backdrop-blur-sm border border-white/30">
                        <i class="fas fa-map-marked-alt mr-3"></i>
                        Lihat Peta
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section id="timeline" class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Timeline Sejarah Indonesia 📅</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Perjalanan panjang bangsa Indonesia dari masa ke masa</p>
            </div>
            
            <div class="space-y-16">
                <!-- Era Kerajaan -->
                <div class="fade-in-up">
                    <div class="bg-primary/10 rounded-3xl p-8 lg:p-12">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div>
                                <div class="text-6xl mb-6">👑</div>
                                <h3 class="text-3xl lg:text-4xl font-bold text-primary mb-6">Era Kerajaan Kuno</h3>
                                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                                    Masa kejayaan kerajaan-kerajaan besar seperti Sriwijaya, Majapahit, dan Mataram yang menguasai Nusantara dengan kekuatan maritim dan perdagangan yang luar biasa.
                                </p>
                                <div class="flex items-center space-x-4 text-primary font-semibold">
                                    <span class="bg-primary/20 px-4 py-2 rounded-full">7-16 Masehi</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-2xl p-8 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Kerajaan Terkenal:</h4>
                                <ul class="space-y-3 text-gray-700">
                                    <li class="flex items-center"><i class="fas fa-crown text-primary mr-3"></i>Kerajaan Sriwijaya (7-13 M)</li>
                                    <li class="flex items-center"><i class="fas fa-crown text-primary mr-3"></i>Kerajaan Majapahit (1293-1527)</li>
                                    <li class="flex items-center"><i class="fas fa-crown text-primary mr-3"></i>Kerajaan Mataram (1586-1755)</li>
                                    <li class="flex items-center"><i class="fas fa-crown text-primary mr-3"></i>Kesultanan Demak (1475-1554)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Era Kolonial -->
                <div class="fade-in-up">
                    <div class="bg-secondary/10 rounded-3xl p-8 lg:p-12">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div class="lg:order-2">
                                <div class="text-6xl mb-6">⚔️</div>
                                <h3 class="text-3xl lg:text-4xl font-bold text-secondary mb-6">Era Kolonial</h3>
                                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                                    Periode penjajahan oleh bangsa Eropa yang membawa perubahan besar dalam sistem pemerintahan, ekonomi, dan sosial budaya masyarakat Indonesia.
                                </p>
                                <div class="flex items-center space-x-4 text-secondary font-semibold">
                                    <span class="bg-secondary/20 px-4 py-2 rounded-full">1602-1945</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-2xl p-8 shadow-lg lg:order-1">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Periode Penting:</h4>
                                <ul class="space-y-3 text-gray-700">
                                    <li class="flex items-center"><i class="fas fa-ship text-secondary mr-3"></i>VOC (1602-1799)</li>
                                    <li class="flex items-center"><i class="fas fa-flag text-secondary mr-3"></i>Hindia Belanda (1800-1942)</li>
                                    <li class="flex items-center"><i class="fas fa-exclamation-triangle text-secondary mr-3"></i>Pendudukan Jepang (1942-1945)</li>
                                    <li class="flex items-center"><i class="fas fa-fist-raised text-secondary mr-3"></i>Perlawanan Rakyat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Era Kemerdekaan -->
                <div class="fade-in-up">
                    <div class="bg-tertiary/10 rounded-3xl p-8 lg:p-12">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <div>
                                <div class="text-6xl mb-6">🇮🇩</div>
                                <h3 class="text-3xl lg:text-4xl font-bold text-tertiary mb-6">Era Kemerdekaan</h3>
                                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                                    Perjuangan mempertahankan kemerdekaan dan membangun bangsa Indonesia yang merdeka, bersatu, dan berdaulat hingga sekarang.
                                </p>
                                <div class="flex items-center space-x-4 text-tertiary font-semibold">
                                    <span class="bg-tertiary/20 px-4 py-2 rounded-full">1945-Sekarang</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-2xl p-8 shadow-lg">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Momen Bersejarah:</h4>
                                <ul class="space-y-3 text-gray-700">
                                    <li class="flex items-center"><i class="fas fa-calendar-day text-tertiary mr-3"></i>Proklamasi 17 Agustus 1945</li>
                                    <li class="flex items-center"><i class="fas fa-handshake text-tertiary mr-3"></i>Pengakuan Kedaulatan 1949</li>
                                    <li class="flex items-center"><i class="fas fa-vote-yea text-tertiary mr-3"></i>Era Reformasi 1998</li>
                                    <li class="flex items-center"><i class="fas fa-building text-tertiary mr-3"></i>Indonesia Modern</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Stories Section -->
    <section id="stories" class="py-20 px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Cerita Sejarah Trending! 🔥</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Baca cerita-cerita seru yang lagi viral di kalangan anak muda!</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Story Card 1 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up">
                    <div class="text-5xl mb-6">👑</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ratu Kalinyamat: Wonder Woman Jawa</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Kisah seorang ratu yang memimpin armada laut melawan Portugis. Keren banget kan?</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-medium">Trending</span>
                        <button class="text-primary hover:text-primary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Story Card 2 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-5xl mb-6">⚔️</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pangeran Diponegoro: Rebel with a Cause</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Perjuangan seorang pangeran yang menentang kolonial demi rakyatnya. Inspiratif!</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium">Popular</span>
                        <button class="text-secondary hover:text-secondary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Story Card 3 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 0.4s;">
                    <div class="text-5xl mb-6">🚢</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Laksamana Cheng Ho: Admiral dari Tiongkok</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Petualangan laksamana legendaris yang menjelajahi Nusantara. Epic!</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-tertiary/20 text-tertiary px-3 py-1 rounded-full text-sm font-medium">Epic</span>
                        <button class="text-tertiary hover:text-tertiary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Story Card 4 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 0.6s;">
                    <div class="text-5xl mb-6">📜</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sumpah Palapa: Netflix Series Majapahit</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Drama politik dan intriga kerajaan yang lebih seru dari K-Drama!</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-quaternary text-primary px-3 py-1 rounded-full text-sm font-medium">Viral</span>
                        <button class="text-primary hover:text-primary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Story Card 5 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 0.8s;">
                    <div class="text-5xl mb-6">💎</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Rempah-Rempah: Gold Rush Indonesia</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Cerita gimana rempah Indonesia bikin dunia berebut datang ke sini!</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium">Amazing</span>
                        <button class="text-secondary hover:text-secondary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Story Card 6 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 1s;">
                    <div class="text-5xl mb-6">🎭</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Kebudayaan Nusantara: Diversity Goals</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Kekayaan budaya Indonesia yang bikin bangga jadi anak bangsa!</p>
                    <div class="flex items-center justify-between">
                        <span class="bg-tertiary/20 text-tertiary px-3 py-1 rounded-full text-sm font-medium">Cultural</span>
                        <button class="text-tertiary hover:text-tertiary/80 font-semibold">Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Learning Section -->
    <section class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Peta Sejarah Indonesia! 🗺️</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Jelajahi lokasi bersejarah Indonesia dalam peta interaktif!</p>
            </div>
            
            <!-- Map Container -->
            <div class="fade-in-up mb-12">
                <div class="bg-gray-50 rounded-3xl p-8 shadow-lg">
                    <!-- Era Filter Buttons -->
                    <div class="flex flex-wrap justify-center gap-3 mb-8">
                        <button id="btn-all" class="era-filter-btn bg-primary text-white px-4 py-2 lg:px-6 lg:py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 active text-sm lg:text-base">
                            <i class="fas fa-globe mr-1 lg:mr-2"></i>Semua Era
                        </button>
                        <button id="btn-kerajaan" class="era-filter-btn bg-gray-200 text-gray-700 px-4 py-2 lg:px-6 lg:py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 text-sm lg:text-base">
                            <i class="fas fa-crown mr-1 lg:mr-2"></i>Era Kerajaan
                        </button>
                        <button id="btn-penjajahan" class="era-filter-btn bg-gray-200 text-gray-700 px-4 py-2 lg:px-6 lg:py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 text-sm lg:text-base">
                            <i class="fas fa-ship mr-1 lg:mr-2"></i>Era Penjajahan
                        </button>
                        <button id="btn-kemerdekaan" class="era-filter-btn bg-gray-200 text-gray-700 px-4 py-2 lg:px-6 lg:py-3 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 text-sm lg:text-base">
                            <i class="fas fa-flag mr-1 lg:mr-2"></i>Era Kemerdekaan
                        </button>
                    </div>
                    
                    <!-- Map -->
                    <div id="map" class="w-full h-96 lg:h-[500px] rounded-2xl shadow-lg"></div>
                    
                    <!-- Map Legend -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-medium text-sm lg:text-base">Era Kerajaan</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="w-4 h-4 bg-red-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-medium text-sm lg:text-base">Era Penjajahan</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="w-4 h-4 bg-blue-500 rounded-full shadow-sm"></div>
                            <span class="text-gray-700 font-medium text-sm lg:text-base">Era Kemerdekaan</span>
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
        'kerajaan': '#eab308', // yellow-500
        'penjajahan': '#ef4444', // red-500  
        'kemerdekaan': '#3b82f6', // blue-500
        'prasejarah': '#10b981' // green-500
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
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                // Add active class to clicked button
                this.classList.remove('bg-gray-200', 'text-gray-700');
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
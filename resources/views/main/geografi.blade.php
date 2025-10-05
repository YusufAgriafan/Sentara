@extends('layouts.main')

@section('title', 'Geografi Indonesia')

@section('content')
    <!-- Hero Section for Geografi -->
    <section class="pt-32 pb-24 px-6 lg:px-8 bg-primary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">🌍</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Model 3D <span class="text-secondary">Geografi</span> Indonesia
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Jelajahi geografi Indonesia dengan teknologi 3D interaktif! Pembelajaran yang lebih mendalam dan menarik.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('models')" class="bg-white hover:bg-secondary text-primary px-10 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-cube mr-3"></i>
                        Lihat Model 3D
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Geography Content Section -->
    @if(isset($geographyContents) && $geographyContents->count() > 0)
    <section class="py-24 px-6 lg:px-8 bg-quaternary">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Penjelasan Geografi 📚</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">
                    Pilih topik geografi yang ingin dipelajari dari dropdown di bawah ini.
                </p>
            </div>

            <!-- Geography Topic Selector -->
            <div class="max-w-4xl mx-auto fade-in-up">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Dropdown Header -->
                    <div class="bg-tertiary p-8">
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Pilih Topik Geografi</h3>
                        <p class="text-gray-700">Klik dropdown untuk memilih materi yang ingin dipelajari</p>
                    </div>

                    <!-- Dropdown Selector -->
                    <div class="p-8">
                        <div class="relative">
                            <select id="geography-selector" onchange="showSelectedGeographyContent()" 
                                    class="w-full bg-quaternary border-2 border-gray-300 rounded-2xl px-6 py-4 text-lg font-medium text-gray-700 focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all duration-300">
                                <option value="">-- Pilih Topik Geografi --</option>
                                @foreach($geographyContents as $content)
                                    <option value="{{ $content->slug }}" 
                                            data-title="{{ $content->title }}"
                                            data-description="{{ $content->description }}"
                                            data-icon="{{ $content->icon }}"
                                            data-order="{{ $content->order_index + 1 }}">
                                    {{ $content->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none">
                                <i class="fas fa-chevron-down text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Display Area -->
                <div id="geography-content-area" class="mt-10 hidden">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <!-- Content Header -->
                        <div id="content-header" class="bg-secondary p-8">
                            <div class="flex items-center mb-6">
                                <div id="content-icon" class="text-6xl mr-6">🌍</div>
                                <div>
                                    <div class="flex items-center mb-3">
                                        <span id="content-badge" class="bg-primary text-white px-4 py-2 rounded-full text-sm font-bold mr-4">
                                            Materi 1
                                        </span>
                                    </div>
                                    <h3 id="content-title" class="text-3xl font-bold text-gray-900"></h3>
                                </div>
                            </div>
                            <p id="content-description" class="text-gray-700 text-lg leading-relaxed"></p>
                        </div>

                        <!-- Content Body -->
                        <div id="content-body" class="p-10">
                            <div class="text-center py-16">
                                <div class="text-6xl mb-6">📖</div>
                                <p class="text-gray-500 text-lg">Memuat konten...</p>
                            </div>
                        </div>

                        <!-- Content Actions -->
                        <div class="bg-quaternary px-8 py-6 flex items-center justify-between">
                            <div class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-primary"></i>
                                Konten pembelajaran geografi Indonesia
                            </div>
                            <button onclick="showFullContent()" 
                                    class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-expand mr-2"></i>Baca Lengkap
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Default State Message -->
                <div id="default-message" class="mt-10 text-center bg-white rounded-3xl p-16 shadow-xl border border-gray-100">
                    <div class="text-8xl mb-8">🎯</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">Siap untuk Belajar Geografi?</h3>
                    <p class="text-gray-600 text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                        Pilih salah satu topik dari dropdown di atas untuk memulai pembelajaran geografi Indonesia yang menarik dan interaktif.
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                        <div class="bg-quaternary rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-mountain text-primary mb-3 text-2xl"></i>
                            <div class="font-bold text-gray-800">Topografi</div>
                        </div>
                        <div class="bg-quaternary rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-water text-primary mb-3 text-2xl"></i>
                            <div class="font-bold text-gray-800">Hidrologi</div>
                        </div>
                        <div class="bg-quaternary rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-cloud-sun text-primary mb-3 text-2xl"></i>
                            <div class="font-bold text-gray-800">Klimatologi</div>
                        </div>
                        <div class="bg-quaternary rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-seedling text-primary mb-3 text-2xl"></i>
                            <div class="font-bold text-gray-800">Biogeografi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 3D Geography Models Section -->
    @if(isset($geographyModels) && $geographyModels->count() > 0)
    <section id="models" class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Model 3D Interaktif 🌍</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">
                    Eksplorasi mendalam geografi Indonesia dengan teknologi 3D yang menghadirkan pengalaman belajar yang immersive!
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($geographyModels as $model)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-100" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                        <!-- 3D Model Embed Display -->
                        <div class="relative h-64 bg-quaternary overflow-hidden">
                            @if($model->embed_code)
                                <div class="w-full h-full">
                                    {!! $model->safe_embed_code !!}
                                </div>
                            @else
                                <div class="bg-secondary h-full flex items-center justify-center text-gray-900">
                                    <div class="text-center z-10">
                                        <div class="text-6xl mb-4">🌐</div>
                                        <h3 class="text-xl font-bold">{{ $model->title }}</h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                @if($model->category)
                                    <span class="bg-tertiary text-gray-900 px-4 py-2 rounded-full text-sm font-bold capitalize">
                                        {{ str_replace('_', ' ', $model->category) }}
                                    </span>
                                @endif
                                <div class="flex items-center text-gray-500 text-sm font-medium">
                                    <i class="fas fa-eye mr-2"></i>
                                    <span>{{ $model->views }}</span>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $model->title }}</h3>
                            
                            <p class="text-gray-600 leading-relaxed mb-6">
                                {{ Str::limit($model->description, 100) }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $model->educator->name }}
                                </div>
                                <div>
                                    {{ $model->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <button onclick="view3DModel({{ $model->id }}, '{{ addslashes($model->title) }}', '{{ addslashes($model->description) }}')" 
                                    class="w-full bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-expand mr-3"></i>Tampilkan Fullscreen
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Models Button -->
            <div class="text-center mt-16 fade-in-up">
                <p class="text-gray-600 mb-8 text-lg">Ada lebih banyak model 3D menarik lainnya!</p>
                <button onclick="loadMore3DModels()" class="bg-primary hover:bg-primary/90 text-white px-12 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-3"></i>Lihat Semua Model 3D
                </button>
            </div>
        </div>
    </section>
    @else
    <!-- No Models Available -->
    <section id="models" class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="bg-quaternary rounded-3xl p-16">
                <div class="text-8xl mb-8">🌍</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Model 3D Segera Hadir!</h2>
                <p class="text-xl text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">Tim educator kami sedang mempersiapkan model 3D geografi yang menarik untuk pembelajaran yang lebih interaktif.</p>
                <div class="bg-white rounded-3xl p-8 shadow-lg max-w-md mx-auto">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Yang Akan Datang:</h3>
                    <ul class="text-left text-gray-600 space-y-3">
                        <li class="flex items-center"><i class="fas fa-mountain text-primary mr-3"></i>Model 3D Gunung Berapi</li>
                        <li class="flex items-center"><i class="fas fa-water text-primary mr-3"></i>Ekosistem Laut Indonesia</li>
                        <li class="flex items-center"><i class="fas fa-tree text-primary mr-3"></i>Hutan Hujan Tropis</li>
                        <li class="flex items-center"><i class="fas fa-globe-asia text-primary mr-3"></i>Formasi Geologis</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 3D Model Modal -->
    <div id="model3d-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-6xl max-h-[90vh] w-full overflow-hidden shadow-2xl">
            <!-- Modal Header -->
            <div class="bg-primary text-white p-8 flex items-center justify-between">
                <div>
                    <h3 id="modal-title" class="text-2xl font-bold"></h3>
                    <p id="modal-description" class="text-white/90 mt-2"></p>
                </div>
                <button onclick="close3DModal()" class="text-white hover:text-white/70 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div id="modal-content" class="h-96 lg:h-[500px] bg-quaternary">
                <!-- 3D Model will be loaded here -->
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 bg-quaternary flex items-center justify-between">
                <div class="text-sm text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-primary"></i>
                    Gunakan mouse untuk merotasi dan zoom model 3D
                </div>
                <button onclick="close3DModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-2xl font-bold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Geography Content Modal -->
    <div id="geography-content-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-4xl max-h-[90vh] w-full overflow-hidden shadow-2xl">
            <!-- Modal Header -->
            <div class="bg-tertiary p-8 flex items-center justify-between">
                <div>
                    <h3 id="content-modal-title" class="text-2xl font-bold text-gray-900"></h3>
                    <p class="text-gray-700 mt-2">Penjelasan Materi Geografi</p>
                </div>
                <button onclick="closeGeographyContentModal()" class="text-gray-900 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div id="geography-modal-content" class="p-8 max-h-[60vh] overflow-y-auto">
                <!-- Content will be loaded here -->
                <div class="text-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-6"></div>
                    <p class="text-gray-600">Memuat konten...</p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 bg-quaternary flex items-center justify-between">
                <div class="text-sm text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-primary"></i>
                    Konten ini disusun khusus untuk pembelajaran geografi Indonesia
                </div>
                <button onclick="closeGeographyContentModal()" 
                        class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-2xl font-bold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <style>
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-lift:hover {
            transform: translateY(-8px);
        }

        /* Custom scrollbar for better UX */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #3396D3; /* primary color */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2A7BB8; /* darker primary */
        }
    </style>

    <script>
        // View 3D Model with actual embed code
        function view3DModel(modelId, title, description) {
            // Show modal
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-description').textContent = description;
            document.getElementById('model3d-modal').classList.remove('hidden');
            document.getElementById('model3d-modal').classList.add('flex');
            
            // Loading state
            document.getElementById('modal-content').innerHTML = `
                <div class="w-full h-full bg-quaternary rounded-xl flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-6xl mb-6 animate-spin">🌐</div>
                        <h4 class="text-xl font-bold text-gray-700 mb-3">Loading 3D Model...</h4>
                        <p class="text-gray-600">Model "${title}" sedang dimuat</p>
                        <div class="mt-6 bg-white rounded-2xl p-4 shadow-sm">
                            <div class="flex items-center justify-center space-x-3">
                                <div class="w-3 h-3 bg-primary rounded-full animate-pulse"></div>
                                <div class="w-3 h-3 bg-primary rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="w-3 h-3 bg-primary rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Fetch actual 3D model embed code
            fetch(`/api/geography-models/${modelId}/embed`)
                .then(response => response.json())
                .then(data => {
                    if (data.embed_code) {
                        document.getElementById('modal-content').innerHTML = data.embed_code;
                    } else {
                        // Fallback content
                        document.getElementById('modal-content').innerHTML = `
                            <div class="w-full h-full bg-secondary rounded-xl flex items-center justify-center border-2 border-dashed border-primary/30">
                                <div class="text-center max-w-md">
                                    <div class="text-8xl mb-6">🌍</div>
                                    <h4 class="text-2xl font-bold text-gray-900 mb-3">${title}</h4>
                                    <p class="text-gray-700 mb-8">${description}</p>
                                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                                        <p class="text-sm text-gray-600 mb-3 flex items-center">
                                            <i class="fas fa-mouse-pointer mr-3 text-primary"></i>Klik dan drag untuk merotasi
                                        </p>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-search-plus mr-3 text-primary"></i>Scroll untuk zoom in/out
                                        </p>
                                    </div>
                                    <div class="mt-6 text-sm text-gray-500 bg-quaternary rounded-xl p-3">
                                        Model 3D sedang dalam proses pengembangan
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading 3D model:', error);
                    // Show error state
                    document.getElementById('modal-content').innerHTML = `
                        <div class="w-full h-full bg-red-50 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-6xl mb-6">⚠️</div>
                                <h4 class="text-xl font-bold text-red-700 mb-3">Gagal Memuat Model</h4>
                                <p class="text-red-600">Silakan coba lagi nanti</p>
                            </div>
                        </div>
                    `;
                });
        }

        // Close 3D Model Modal
        function close3DModal() {
            document.getElementById('model3d-modal').classList.add('hidden');
            document.getElementById('model3d-modal').classList.remove('flex');
        }

        // Load more 3D models
        function loadMore3DModels() {
            // In real implementation, this would load more models via AJAX
            alert('Fitur ini akan menampilkan lebih banyak model 3D dalam versi lengkap aplikasi!');
        }

        // Show Geography Content Modal
        function showGeographyContent(slug) {
            const modal = document.getElementById('geography-content-modal');
            const modalContent = document.getElementById('geography-modal-content');
            const modalTitle = document.getElementById('content-modal-title');
            
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Show loading state
            modalContent.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-tertiary mx-auto mb-4"></div>
                    <p class="text-gray-600">Memuat konten...</p>
                </div>
            `;
            
            // Fetch content
            fetch(`/api/geography-content/${slug}`)
                .then(response => response.json())
                .then(data => {
                    modalTitle.textContent = data.title;
                    modalContent.innerHTML = `
                        <div class="prose prose-lg max-w-none">
                            ${data.description ? `<div class="bg-tertiary/10 border-l-4 border-tertiary p-4 mb-6">
                                <p class="text-indigo-700 font-medium">${data.description}</p>
                            </div>` : ''}
                            <div class="text-gray-700 leading-relaxed">
                                ${data.content}
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error loading geography content:', error);
                    modalContent.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">⚠️</div>
                            <h4 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Konten</h4>
                            <p class="text-red-600">Silakan coba lagi nanti</p>
                        </div>
                    `;
                });
        }

        // Close Geography Content Modal
        function closeGeographyContentModal() {
            document.getElementById('geography-content-modal').classList.add('hidden');
            document.getElementById('geography-content-modal').classList.remove('flex');
        }

        // Smooth scrolling function
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Close modal when clicking outside
        document.getElementById('model3d-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                close3DModal();
            }
        });
        
        // Close geography content modal when clicking outside
        document.getElementById('geography-content-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGeographyContentModal();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                close3DModal();
                closeGeographyContentModal();
            }
        });

        // Auto-hide loading animations
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            });

            fadeElements.forEach(el => {
                observer.observe(el);
            });
        });

        // Show selected geography content
        function showSelectedGeographyContent() {
            const selector = document.getElementById('geography-selector');
            const selectedOption = selector.options[selector.selectedIndex];
            const contentArea = document.getElementById('geography-content-area');
            const defaultMessage = document.getElementById('default-message');
            
            if (selectedOption.value === '') {
                // Show default message, hide content area
                contentArea.classList.add('hidden');
                defaultMessage.classList.remove('hidden');
                return;
            }
            
            // Hide default message, show content area
            defaultMessage.classList.add('hidden');
            contentArea.classList.remove('hidden');
            
            // Update content header
            document.getElementById('content-icon').innerHTML = selectedOption.dataset.icon || '🌍';
            document.getElementById('content-badge').textContent = `Materi ${selectedOption.dataset.order}`;
            document.getElementById('content-title').textContent = selectedOption.dataset.title;
            document.getElementById('content-description').textContent = selectedOption.dataset.description || 'Pelajari lebih lanjut tentang topik geografi ini.';
            
            // Show loading in content body
            document.getElementById('content-body').innerHTML = `
                <div class="text-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-tertiary mx-auto mb-4"></div>
                    <p class="text-gray-500 text-lg">Memuat konten...</p>
                </div>
            `;
            
            // Fetch content
            fetch(`/api/geography-content/${selectedOption.value}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('content-body').innerHTML = `
                        <div class="prose prose-lg max-w-none">
                            <div class="text-gray-700 leading-relaxed">
                                ${data.content ? data.content.substring(0, 500) + '...' : 'Konten sedang dalam pengembangan.'}
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error loading geography content:', error);
                    document.getElementById('content-body').innerHTML = `
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">⚠️</div>
                            <h4 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Konten</h4>
                            <p class="text-red-600">Silakan coba lagi nanti</p>
                        </div>
                    `;
                });
            
            // Smooth scroll to content area
            contentArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        // Show full content in modal
        function showFullContent() {
            const selector = document.getElementById('geography-selector');
            const selectedOption = selector.options[selector.selectedIndex];
            
            if (selectedOption.value) {
                showGeographyContent(selectedOption.value);
            }
        }
    </script>
@endsection
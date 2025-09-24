@extends('layouts.main')

@section('title', 'Geografi Indonesia')

@section('content')
    <!-- Hero Section for Geografi -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-br from-primary to-secondary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">🌍</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Model 3D <span class="text-yellow-300">Geografi</span> Indonesia
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Jelajahi geografi Indonesia dengan teknologi 3D interaktif! Pembelajaran yang lebih mendalam dan menarik.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('models')" class="bg-white hover:bg-gray-100 text-primary px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-cube mr-3"></i>
                        Lihat Model 3D
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Geography Content Section -->
    @if(isset($geographyContents) && $geographyContents->count() > 0)
    <section class="py-20 px-6 lg:px-8 bg-gradient-to-br from-quaternary/20 to-quaternary/40">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Penjelasan Geografi 📚</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">
                    Pilih topik geografi yang ingin dipelajari dari dropdown di bawah ini.
                </p>
            </div>

            <!-- Geography Topic Selector -->
            <div class="max-w-4xl mx-auto fade-in-up">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    <!-- Dropdown Header -->
                    <div class="bg-gradient-to-r from-tertiary to-primary p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Pilih Topik Geografi</h3>
                        <p class="text-orange-100">Klik dropdown untuk memilih materi yang ingin dipelajari</p>
                    </div>

                    <!-- Dropdown Selector -->
                    <div class="p-6">
                        <div class="relative">
                            <select id="geography-selector" onchange="showSelectedGeographyContent()" 
                                    class="w-full bg-white border-2 border-gray-300 rounded-xl px-4 py-3 text-lg font-medium text-gray-700 focus:border-tertiary focus:outline-none focus:ring-2 focus:ring-tertiary/20 transition-all duration-300">
                                <option value="">-- Pilih Topik Geografi --</option>
                                @foreach($geographyContents as $content)
                                    <option value="{{ $content->slug }}" 
                                            data-title="{{ $content->title }}"
                                            data-description="{{ $content->description }}"
                                            data-icon="{{ $content->icon }}"
                                            data-order="{{ $content->order_index + 1 }}">
                                        Materi {{ $content->order_index + 1 }}: {{ $content->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Display Area -->
                <div id="geography-content-area" class="mt-8 hidden">
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <!-- Content Header -->
                        <div id="content-header" class="bg-gradient-to-r from-tertiary to-primary p-6 text-white">
                            <div class="flex items-center mb-4">
                                <div id="content-icon" class="text-6xl mr-4">🌍</div>
                                <div>
                                    <div class="flex items-center mb-2">
                                        <span id="content-badge" class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium mr-3">
                                            Materi 1
                                        </span>
                                    </div>
                                    <h3 id="content-title" class="text-3xl font-bold"></h3>
                                </div>
                            </div>
                            <p id="content-description" class="text-blue-100 text-lg leading-relaxed"></p>
                        </div>

                        <!-- Content Body -->
                        <div id="content-body" class="p-8">
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">📖</div>
                                <p class="text-gray-500 text-lg">Memuat konten...</p>
                            </div>
                        </div>

                        <!-- Content Actions -->
                        <div class="bg-gray-50 px-8 py-6 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Konten pembelajaran geografi Indonesia
                            </div>
                            <button onclick="showFullContent()" 
                                    class="bg-tertiary hover:bg-primary text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 hover:scale-105">
                                <i class="fas fa-expand mr-2"></i>Baca Lengkap
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Default State Message -->
                <div id="default-message" class="mt-8 text-center bg-white rounded-3xl p-12 shadow-lg">
                    <div class="text-8xl mb-6">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Siap untuk Belajar Geografi?</h3>
                    <p class="text-gray-600 text-lg mb-6 max-w-2xl mx-auto">
                        Pilih salah satu topik dari dropdown di atas untuk memulai pembelajaran geografi Indonesia yang menarik dan interaktif.
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto text-sm text-gray-500">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <i class="fas fa-mountain text-primary mb-1"></i>
                            <div class="font-medium">Topografi</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <i class="fas fa-water text-secondary mb-1"></i>
                            <div class="font-medium">Hidrologi</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <i class="fas fa-cloud-sun text-tertiary mb-1"></i>
                            <div class="font-medium">Klimatologi</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <i class="fas fa-seedling text-primary mb-1"></i>
                            <div class="font-medium">Biogeografi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 3D Geography Models Section -->
    @if(isset($geographyModels) && $geographyModels->count() > 0)
    <section id="models" class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Model 3D Interaktif 🌍</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">
                    Eksplorasi mendalam geografi Indonesia dengan teknologi 3D yang menghadirkan pengalaman belajar yang immersive!
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($geographyModels as $model)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 fade-in-up" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                        <!-- 3D Model Embed Display -->
                        <div class="relative h-64 bg-gray-100 overflow-hidden">
                            @if($model->embed_code)
                                <div class="w-full h-full">
                                    {!! $model->safe_embed_code !!}
                                </div>
                            @else
                                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 h-full flex items-center justify-center text-white">
                                    <div class="text-center z-10">
                                        <div class="text-6xl mb-4">🌐</div>
                                        <h3 class="text-xl font-bold">{{ $model->title }}</h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                @if($model->category)
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium capitalize">
                                        {{ str_replace('_', ' ', $model->category) }}
                                    </span>
                                @endif
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>{{ $model->views }}</span>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $model->title }}</h3>
                            
                            <p class="text-gray-600 leading-relaxed mb-4">
                                {{ Str::limit($model->description, 100) }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $model->educator->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $model->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <button onclick="view3DModel({{ $model->id }}, '{{ addslashes($model->title) }}', '{{ addslashes($model->description) }}')" 
                                    class="w-full bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-expand mr-2"></i>Tampilkan Fullscreen
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Models Button -->
            <div class="text-center mt-12 fade-in-up">
                <p class="text-gray-600 mb-6">Ada lebih banyak model 3D menarik lainnya!</p>
                <button onclick="loadMore3DModels()" class="bg-primary hover:bg-secondary text-white px-8 py-4 rounded-2xl text-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-3"></i>Lihat Semua Model 3D
                </button>
            </div>
        </div>
    </section>
    @else
    <!-- No Models Available -->
    <section id="models" class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="bg-gradient-to-br from-quaternary/20 to-quaternary/40 rounded-3xl p-12">
                <div class="text-8xl mb-6">🌍</div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Model 3D Segera Hadir!</h2>
                <p class="text-xl text-gray-600 mb-8">Tim educator kami sedang mempersiapkan model 3D geografi yang menarik untuk pembelajaran yang lebih interaktif.</p>
                <div class="bg-white rounded-2xl p-6 shadow-lg max-w-md mx-auto">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Yang Akan Datang:</h3>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li><i class="fas fa-mountain text-primary mr-2"></i>Model 3D Gunung Berapi</li>
                        <li><i class="fas fa-water text-secondary mr-2"></i>Ekosistem Laut Indonesia</li>
                        <li><i class="fas fa-tree text-tertiary mr-2"></i>Hutan Hujan Tropis</li>
                        <li><i class="fas fa-globe-asia text-primary mr-2"></i>Formasi Geologis</li>
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
            <div class="bg-primary text-white p-6 flex items-center justify-between">
                <div>
                    <h3 id="modal-title" class="text-2xl font-bold"></h3>
                    <p id="modal-description" class="text-red-100 mt-1"></p>
                </div>
                <button onclick="close3DModal()" class="text-white hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div id="modal-content" class="h-96 lg:h-[500px] bg-gray-100">
                <!-- 3D Model will be loaded here -->
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-2"></i>
                    Gunakan mouse untuk merotasi dan zoom model 3D
                </div>
                <button onclick="close3DModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Geography Content Modal -->
    <div id="geography-content-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-4xl max-h-[90vh] w-full overflow-hidden shadow-2xl">
            <!-- Modal Header -->
            <div class="bg-tertiary text-white p-6 flex items-center justify-between">
                <div>
                    <h3 id="content-modal-title" class="text-2xl font-bold"></h3>
                    <p class="text-orange-100 mt-1">Penjelasan Materi Geografi</p>
                </div>
                <button onclick="closeGeographyContentModal()" class="text-white hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div id="geography-modal-content" class="p-6 max-h-[60vh] overflow-y-auto">
                <!-- Content will be loaded here -->
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                    <p class="text-gray-600">Memuat konten...</p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-2"></i>
                    Konten ini disusun khusus untuk pembelajaran geografi Indonesia
                </div>
                <button onclick="closeGeographyContentModal()" 
                        class="bg-tertiary hover:bg-primary text-white px-4 py-2 rounded-lg font-medium transition-colors">
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
            background: rgb(106, 38, 52); /* primary color */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgb(148, 57, 57); /* secondary color */
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
                <div class="w-full h-full bg-gradient-to-br from-quaternary/20 to-quaternary/40 rounded-xl flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-6xl mb-4 animate-spin">🌐</div>
                        <h4 class="text-xl font-bold text-gray-700 mb-2">Loading 3D Model...</h4>
                        <p class="text-gray-600">Model "${title}" sedang dimuat</p>
                        <div class="mt-4 bg-white rounded-lg p-3 shadow-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                                <div class="w-2 h-2 bg-primary rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="w-2 h-2 bg-primary rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
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
                            <div class="w-full h-full bg-gradient-to-br from-quaternary/10 to-quaternary/30 rounded-xl flex items-center justify-center border-2 border-dashed border-primary/30">
                                <div class="text-center max-w-md">
                                    <div class="text-8xl mb-4">🌍</div>
                                    <h4 class="text-2xl font-bold text-emerald-700 mb-2">${title}</h4>
                                    <p class="text-emerald-600 mb-6">${description}</p>
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <p class="text-sm text-gray-600 mb-2">
                                            <i class="fas fa-mouse-pointer mr-2"></i>Klik dan drag untuk merotasi
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-search-plus mr-2"></i>Scroll untuk zoom in/out
                                        </p>
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">
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
                                <div class="text-6xl mb-4">⚠️</div>
                                <h4 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Model</h4>
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
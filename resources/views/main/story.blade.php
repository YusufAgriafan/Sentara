@extends('layouts.main')

@section('title', $story->title)

@section('content')
    <!-- Hero Section for Story -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-br from-primary to-secondary text-white">
        <div class="max-w-4xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-6xl mb-6">📚</div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    {{ $story->title }}
                </h1>
                <p class="text-lg lg:text-xl text-white/90 mb-8 leading-relaxed">
                    {{ $story->excerpt ?? 'Cerita menarik dari masa lalu Indonesia' }}
                </p>
                <div class="flex items-center justify-center space-x-6 text-white/80">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $story->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clock"></i>
                        <span>{{ ceil(str_word_count($story->content) / 200) }} menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg prose-primary max-w-none fade-in-up prose-headings:text-gray-900 prose-p:text-gray-700 prose-strong:text-gray-900 prose-em:text-gray-700 prose-blockquote:border-primary prose-blockquote:text-gray-700 prose-code:text-primary prose-pre:bg-gray-100">
                {!! Str::markdown($story->content) !!}
            </div>
        </div>
    </section>

    <!-- Related Places Section -->
    @if($story->historical_id && $story->place)
        <section class="py-20 px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 fade-in-up">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">Lokasi Terkait</h2>
                    <p class="text-lg lg:text-xl text-gray-600">Tempat bersejarah yang terkait dengan cerita ini</p>
                </div>
                
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up">
                    <div class="grid lg:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $story->place->name }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">{{ $story->place->description }}</p>
                            <div class="flex items-center space-x-4 text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $story->place->location }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-history"></i>
                                    <span>{{ $story->place->era }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-64 lg:h-80">
                            @if($story->place->image_path)
                                <img src="{{ asset('storage/' . $story->place->image_path) }}" 
                                     alt="{{ $story->place->name }}" 
                                     class="w-full h-full object-cover rounded-2xl shadow-lg">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center">
                                    <div class="text-6xl text-white">🏛️</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Back Navigation -->
    <section class="py-12 px-6 lg:px-8 bg-white border-t border-gray-200">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center">
                <a href="{{ route('sejarah') }}" 
                   class="flex items-center space-x-2 text-primary hover:text-primary/80 font-semibold transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Sejarah</span>
                </a>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-500">Bagikan:</span>
                    <button onclick="shareStory()" class="bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-share-alt mr-2"></i>
                        Share
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        function shareStory() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $story->title }}',
                    text: '{{ Str::limit($story->content, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback untuk browser yang tidak support Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        }
    </script>
@endsection
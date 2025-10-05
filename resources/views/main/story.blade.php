@extends('layouts.main')

@section('title', $story->title)

@section('content')
    <!-- Hero Section for Story -->
    <section class="pt-32 pb-24 px-6 lg:px-8 bg-primary text-white">
        <div class="max-w-4xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">📚</div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-8 leading-tight">
                    {{ $story->title }}
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-10 leading-relaxed">
                    {{ $story->excerpt ?? 'Cerita menarik dari masa lalu Indonesia' }}
                </p>
                <div class="flex items-center justify-center space-x-8 text-white/80">
                    <div class="flex items-center space-x-3 bg-white/20 rounded-2xl px-6 py-3">
                        <i class="fas fa-calendar text-lg"></i>
                        <span class="font-medium">{{ $story->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/20 rounded-2xl px-6 py-3">
                        <i class="fas fa-clock text-lg"></i>
                        <span class="font-medium">{{ ceil(str_word_count($story->content) / 200) }} menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-xl prose-primary max-w-none fade-in-up prose-headings:text-gray-900 prose-p:text-gray-700 prose-strong:text-gray-900 prose-em:text-gray-700 prose-blockquote:border-primary prose-blockquote:text-gray-700 prose-code:text-primary prose-pre:bg-quaternary bg-white rounded-3xl p-12 shadow-xl border border-gray-200">
                {!! Str::markdown($story->content) !!}
            </div>
        </div>
    </section>

    <!-- Related Places Section -->
    @if($story->historical_id && $story->place)
        <section class="py-24 px-6 lg:px-8 bg-quaternary">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20 fade-in-up">
                    <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Lokasi Terkait</h2>
                    <p class="text-xl lg:text-2xl text-gray-600">Tempat bersejarah yang terkait dengan cerita ini</p>
                </div>
                
                <div class="bg-white rounded-3xl p-12 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02] fade-in-up border border-gray-200">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">{{ $story->place->name }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-8 text-lg">{{ $story->place->description }}</p>
                            <div class="flex items-center space-x-6 text-gray-500">
                                <div class="flex items-center space-x-3 bg-quaternary rounded-2xl px-6 py-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <span class="font-medium">{{ $story->place->location }}</span>
                                </div>
                                <div class="flex items-center space-x-3 bg-quaternary rounded-2xl px-6 py-3">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="font-medium">{{ $story->place->era }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="relative h-64 lg:h-80">
                            @if($story->place->image_path)
                                <img src="{{ asset('storage/' . $story->place->image_path) }}" 
                                     alt="{{ $story->place->name }}" 
                                     class="w-full h-full object-cover rounded-3xl shadow-lg">
                            @else
                                <div class="w-full h-full bg-secondary rounded-3xl flex items-center justify-center border border-gray-200">
                                    <div class="text-8xl text-gray-600">🏛️</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Back Navigation -->
    <section class="py-16 px-6 lg:px-8 bg-white border-t border-gray-200">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                <a href="{{ route('sejarah') }}" 
                   class="flex items-center space-x-3 text-primary hover:text-primary/80 font-bold bg-quaternary px-8 py-4 rounded-2xl hover:scale-105 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Sejarah</span>
                </a>
                
                <div class="flex items-center space-x-6">
                    <span class="text-gray-500 font-medium">Bagikan:</span>
                    <button onclick="shareStory()" class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl transition-all duration-300 hover:scale-105 font-bold">
                        <i class="fas fa-share-alt mr-3"></i>
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
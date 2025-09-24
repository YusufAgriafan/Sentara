@extends('layouts.main')

@section('title', $story->title)

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-6 lg:px-8 bg-gradient-to-br from-primary to-secondary text-white">
        <div class="max-w-4xl mx-auto text-center fade-in-up">
            <div class="text-6xl mb-6">📖</div>
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">{{ $story->title }}</h1>
            <div class="flex items-center justify-center space-x-4 text-white/90">
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $story->place->name }}</span>
                </div>
                <div class="text-white/60">•</div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>{{ $story->place->location }}</span>
                </div>
                <div class="text-white/60">•</div>
                <div class="flex items-center">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm">
                        Era {{ ucfirst($story->place->era) }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="py-16 px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- Story Illustration -->
            @if($story->illustration)
                <div class="mb-12 fade-in-up">
                    <img src="{{ $story->illustration }}" 
                         alt="Ilustrasi {{ $story->title }}" 
                         class="w-full h-64 lg:h-96 object-cover rounded-2xl shadow-xl"
                         onerror="this.style.display='none'">
                </div>
            @endif

            <!-- Story Text -->
            <div class="prose prose-lg lg:prose-xl max-w-none fade-in-up prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-primary prose-strong:text-gray-900 prose-em:text-gray-700 prose-blockquote:border-primary prose-blockquote:text-gray-600 prose-code:text-primary prose-pre:bg-gray-50">
                <div class="markdown-content leading-relaxed text-lg lg:text-xl">
                    {!! \Illuminate\Support\Str::markdown($story->content) !!}
                </div>
            </div>

            <!-- Place Information -->
            <div class="mt-16 p-8 bg-gray-50 rounded-2xl fade-in-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tentang Tempat Ini</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $story->place->name }}</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-3 text-primary"></i>
                                <span>{{ $story->place->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-3 text-primary"></i>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                           bg-{{ $story->place->era === 'prasejarah' ? 'green' : ($story->place->era === 'kerajaan' ? 'blue' : ($story->place->era === 'penjajahan' ? 'red' : 'purple')) }}-100 
                                           text-{{ $story->place->era === 'prasejarah' ? 'green' : ($story->place->era === 'kerajaan' ? 'blue' : ($story->place->era === 'penjajahan' ? 'red' : 'purple')) }}-800">
                                    Era {{ ucfirst($story->place->era) }}
                                </span>
                            </div>
                            @if($story->place->coordinate)
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-globe mr-3 text-primary"></i>
                                    <span>{{ $story->place->coordinate->latitude }}, {{ $story->place->coordinate->longitude }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($story->place->description)
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $story->place->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 fade-in-up">
                <a href="{{ route('sejarah') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Peta Sejarah
                </a>
                
                <div class="flex items-center space-x-4">
                    <button onclick="shareStory()" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105">
                        <i class="fas fa-share mr-2"></i>
                        Bagikan Cerita
                    </button>
                    
                    @if($story->place->coordinate)
                        <button onclick="viewOnMap({{ $story->place->coordinate->latitude }}, {{ $story->place->coordinate->longitude }})" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105">
                            <i class="fas fa-map-marked-alt mr-2"></i>
                            Lihat di Peta
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Stories Section (if there are other stories for this place) -->
    @if($story->place->stories->where('id', '!=', $story->id)->count() > 0)
        <section class="py-16 px-6 lg:px-8 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12 fade-in-up">Cerita Lainnya dari {{ $story->place->name }}</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($story->place->stories->where('id', '!=', $story->id)->take(3) as $relatedStory)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-105 fade-in-up">
                            @if($relatedStory->illustration)
                                <img src="{{ $relatedStory->illustration }}" 
                                     alt="{{ $relatedStory->title }}" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.style.display='none'">
                            @endif
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $relatedStory->title }}</h3>
                                <div class="text-gray-600 mb-4 line-clamp-3 prose prose-sm">
                                    {!! \Illuminate\Support\Str::markdown(Str::limit(strip_tags($relatedStory->content), 120)) !!}
                                </div>
                                <a href="{{ route('story.show', $relatedStory->id) }}" 
                                   class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                                    Baca Selengkapnya
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
<script>
    function shareStory() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $story->title }}',
                text: 'Baca cerita menarik tentang {{ $story->place->name }}',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support native sharing
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link cerita telah disalin ke clipboard!');
            }).catch(() => {
                // Fallback if clipboard API is not available
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Link cerita telah disalin ke clipboard!');
            });
        }
    }

    function viewOnMap(lat, lng) {
        // Redirect to sejarah page with coordinates
        window.location.href = `{{ route('sejarah') }}#map?lat=${lat}&lng=${lng}`;
    }

    // Add fade-in animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-4');
            }
        });
    });

    document.querySelectorAll('.fade-in-up').forEach((el) => {
        el.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-700');
        observer.observe(el);
    });
</script>
@endsection
@extends('layouts.main')

@section('title', $story->title)

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-primary text-white">
        <div class="max-w-4xl mx-auto text-center fade-in-up">
            <div class="text-8xl mb-8">📖</div>
            <h1 class="text-4xl lg:text-6xl font-bold mb-8 leading-tight">{{ $story->title }}</h1>
            <div class="flex items-center justify-center space-x-6 text-white/90">
                <div class="flex items-center bg-white/20 rounded-2xl px-6 py-3">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    <span class="font-medium">{{ $story->place->name }}</span>
                </div>
                <div class="text-white/60">•</div>
                <div class="flex items-center bg-white/20 rounded-2xl px-6 py-3">
                    <i class="fas fa-clock mr-3"></i>
                    <span class="font-medium">{{ $story->place->location }}</span>
                </div>
                <div class="text-white/60">•</div>
                <div class="flex items-center">
                    <span class="px-4 py-2 bg-secondary text-gray-900 rounded-full text-sm font-bold">
                        Era {{ ucfirst($story->place->era) }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- Story Illustration -->
            @if($story->illustration)
                <div class="mb-16 fade-in-up">
                    <img src="{{ $story->illustration }}" 
                         alt="Ilustrasi {{ $story->title }}" 
                         class="w-full h-64 lg:h-96 object-cover rounded-3xl shadow-xl border border-gray-200"
                         onerror="this.style.display='none'">
                </div>
            @endif

            <!-- Story Text -->
            <div class="prose prose-xl lg:prose-2xl max-w-none fade-in-up prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-primary prose-strong:text-gray-900 prose-em:text-gray-700 prose-blockquote:border-primary prose-blockquote:text-gray-600 prose-code:text-primary prose-pre:bg-quaternary bg-white rounded-3xl p-12 shadow-xl border border-gray-200">
                <div class="markdown-content leading-relaxed text-xl lg:text-2xl">
                    {!! \Illuminate\Support\Str::markdown($story->content) !!}
                </div>
            </div>

            <!-- Place Information -->
            <div class="mt-20 p-12 bg-quaternary rounded-3xl fade-in-up border border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Tentang Tempat Ini</h2>
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6">{{ $story->place->name }}</h3>
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600 bg-white rounded-2xl px-6 py-4">
                                <i class="fas fa-map-marker-alt mr-4 text-primary text-xl"></i>
                                <span class="font-medium">{{ $story->place->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 bg-white rounded-2xl px-6 py-4">
                                <i class="fas fa-calendar-alt mr-4 text-primary text-xl"></i>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold 
                                           @if($story->place->era === 'prasejarah') bg-secondary text-gray-900
                                           @elseif($story->place->era === 'kerajaan') bg-tertiary text-gray-900
                                           @elseif($story->place->era === 'penjajahan') bg-red-100 text-red-800
                                           @else bg-primary text-white @endif">
                                    Era {{ ucfirst($story->place->era) }}
                                </span>
                            </div>
                            @if($story->place->coordinate)
                                <div class="flex items-center text-gray-600 bg-white rounded-2xl px-6 py-4">
                                    <i class="fas fa-globe mr-4 text-primary text-xl"></i>
                                    <span class="font-medium">{{ $story->place->coordinate->latitude }}, {{ $story->place->coordinate->longitude }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($story->place->description)
                            <h4 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi</h4>
                            <p class="text-gray-700 leading-relaxed text-lg bg-white rounded-2xl p-6">{{ $story->place->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mt-16 flex flex-col sm:flex-row items-center justify-between gap-6 fade-in-up">
                <a href="{{ route('sejarah') }}" 
                   class="inline-flex items-center px-10 py-4 bg-quaternary hover:bg-gray-300 text-gray-700 font-bold rounded-2xl transition-all duration-300 hover:scale-105">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Kembali ke Peta Sejarah
                </a>
                
                <div class="flex items-center space-x-6">
                    <button onclick="shareStory()" 
                            class="inline-flex items-center px-10 py-4 bg-primary hover:bg-primary/90 text-white font-bold rounded-2xl transition-all duration-300 hover:scale-105">
                        <i class="fas fa-share mr-3"></i>
                        Bagikan Cerita
                    </button>
                    
                    @if($story->place->coordinate)
                        <button onclick="viewOnMap({{ $story->place->coordinate->latitude }}, {{ $story->place->coordinate->longitude }})" 
                                class="inline-flex items-center px-10 py-4 bg-secondary hover:bg-tertiary text-gray-900 font-bold rounded-2xl transition-all duration-300 hover:scale-105">
                            <i class="fas fa-map-marked-alt mr-3"></i>
                            Lihat di Peta
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Stories Section (if there are other stories for this place) -->
    @if($story->place->stories->where('id', '!=', $story->id)->count() > 0)
        <section class="py-20 px-6 lg:px-8 bg-quaternary">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-4xl font-bold text-gray-900 text-center mb-16 fade-in-up">Cerita Lainnya dari {{ $story->place->name }}</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($story->place->stories->where('id', '!=', $story->id)->take(3) as $relatedStory)
                        <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200">
                            @if($relatedStory->illustration)
                                <img src="{{ $relatedStory->illustration }}" 
                                     alt="{{ $relatedStory->title }}" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.style.display='none'">
                            @endif
                            <div class="p-8">
                                <h3 class="font-bold text-xl text-gray-900 mb-4">{{ $relatedStory->title }}</h3>
                                <div class="text-gray-600 mb-6 line-clamp-3 prose prose-sm">
                                    {!! \Illuminate\Support\Str::markdown(Str::limit(strip_tags($relatedStory->content), 120)) !!}
                                </div>
                                <a href="{{ route('story.show', $relatedStory->id) }}" 
                                   class="inline-flex items-center text-primary hover:text-primary/80 font-bold bg-quaternary px-6 py-3 rounded-2xl transition-all duration-300 hover:scale-105">
                                    Baca Selengkapnya
                                    <i class="fas fa-arrow-right ml-3"></i>
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
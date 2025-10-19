@extends('home.headerFooter')

@section('title', 'News')

@section('body')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-success">🌿 AgroConnect News</h2>

    <div class="row">
        <!-- Sidebar: Auto-scrolling Latest Headlines -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    📰 Latest Headlines
                </div>
                <div class="card-body p-0">
                    <div class="scroll-container" id="newsScroller">
                        @forelse($latestNews as $news)
                            <div class="p-3 border-bottom">
                                <h6 class="fw-bold mb-1">{{ Str::limit($news->news_name, 70) }}</h6>
                                <small class="text-muted d-block mb-1">
                                    <i class="fa fa-calendar"></i> {{ $news->created_at->format('d M Y') }}
                                </small>
                                <p class="small text-secondary mb-0">{{ Str::limit($news->news_description, 80) }}</p>
                            </div>
                        @empty
                            <p class="p-3 text-center text-muted">No news available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Full News List -->
        <div class="col-md-8">
            <div class="row g-4">
                @forelse($newses as $news)
                    <div class="col-md-12">
                        <div class="card h-100 shadow-lg border-0 rounded-3">
                            <img src="{{ asset($news->news_image) }}" class="card-img-top" alt="News Image" style="height:250px; object-fit:cover;">
                            <div class="card-body">
                                <h4 class="fw-bold">{{ $news->news_name }}</h4>
                                <p class="text-muted"><i class="fa fa-calendar"></i> {{ $news->created_at->format('d M Y') }}</p>
                                <p class="text-secondary">{{ Str::limit($news->long_description, 300) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">🚫 No news found.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $newses->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.scroll-container {
    max-height: 480px;
    overflow: hidden;
    position: relative;
}

.scroll-container > div {
    animation: scrollNews 30s linear infinite;
}
.scroll-container:hover > div {
    animation-play-state: paused;
}

@keyframes scrollNews {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-50%);
    }
}
</style>
@endpush

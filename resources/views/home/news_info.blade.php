@extends('home.headerFooter')

@section('title', 'News')

@section('body')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-success">🌿 AgroConnect News</h2>
    <div class="row g-4">
        @forelse($newses as $news)
            <div class="col-md-4">
                <div class="card h-100 shadow-lg border-0 rounded-3">
                    <img src="{{ url($news->news_image) }}" class="card-img-top" alt="News Image" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $news->news_name }}</h5>
                        <p class="small text-muted">{{ Str::limit($news->news_description, 120) }}</p>
                        <p class="small text-muted"><i class="fa fa-calendar"></i> {{ $news->created_at->format('d M Y') }}</p>
                        <a href="#" class="btn btn-sm btn-outline-success rounded-pill">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">🚫 No news found.</p>
        @endforelse
    </div>

    <!-- ✅ Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $newses->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

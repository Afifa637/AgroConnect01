@extends('home.headerFooter')

@section('title', 'News')

@section('body')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-success">🌿 AgroConnect News</h2>

    <div class="row">
        <!-- Sidebar: Latest Headlines -->
        <div class="col-md-4 mb-4">
            <div class="list-group shadow-sm">
                <h5 class="list-group-item list-group-item-action active bg-success text-white">
                    Latest News
                </h5>
                @foreach($latestNews as $news)
                    <a href="#" class="list-group-item list-group-item-action news-link" 
                       data-news-id="{{ $news->id }}">
                        {{ Str::limit($news->news_name, 50) }}
                        <small class="d-block text-muted">{{ $news->created_at->format('d M Y') }}</small>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Main Content: Full News -->
        <div class="col-md-8">
            <div id="news-content" class="row g-4">
                @if($latestNews->count())
                    @php $news = $latestNews->first(); @endphp
                    <div class="col-12">
                        <div class="card h-100 shadow-lg border-0 rounded-3">
                            <img src="{{ asset($news->news_image) }}" class="card-img-top" alt="News Image" style="height:300px; object-fit:cover;">
                            <div class="card-body">
                                <h4 class="fw-bold">{{ $news->news_name }}</h4>
                                <p class="text-muted"><i class="fa fa-calendar"></i> {{ $news->created_at->format('d M Y') }}</p>
                                <p>{{ $news->long_description }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center">🚫 No news available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('.news-link');
        const contentDiv = document.getElementById('news-content');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const newsId = this.dataset.newsId;

                fetch(`/news/ajax/${newsId}`)
                    .then(res => res.json())
                    .then(data => {
                        contentDiv.innerHTML = `
                        <div class="col-12">
                            <div class="card h-100 shadow-lg border-0 rounded-3">
                                <img src="${data.news_image}" class="card-img-top" alt="${data.news_name}" style="height:300px; object-fit:cover;">
                                <div class="card-body">
                                    <h4 class="fw-bold">${data.news_name}</h4>
                                    <p class="text-muted"><i class="fa fa-calendar"></i> ${data.created_at}</p>
                                    <p>${data.long_description}</p>
                                </div>
                            </div>
                        </div>`;
                    });
            });
        });
    });
</script>
@endpush

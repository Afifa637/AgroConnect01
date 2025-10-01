@extends('home.headerFooter')

@section('title', 'News Info')

@section('body')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @foreach($newses as $news)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ url($news->news_image) }}" class="card-img-top rounded-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $news->news_name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($news->news_description, 100) }}</p>
                            <a href="#" class="btn btn-outline-success w-100">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

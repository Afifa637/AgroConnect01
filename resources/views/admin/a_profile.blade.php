@extends('admin.headerFooter')
@section('title','News & Announcements')
@section('body')

<h2 class="text-agro mb-4">News & Announcements</h2>

<div class="row">
    @foreach($newses as $news)
        <div class="col-lg-3 col-md-6 my-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset($news->news_image) }}" class="card-img-top" alt="{{ $news->news_name }}" style="height:180px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $news->news_name }}</h5>
                    <h6 class="text-muted small">{{ $news->news_description }}</h6>
                    <p class="card-text small text-justify">{{ Str::limit($news->long_description, 120) }}</p>
                </div>
                <div class="card-footer bg-white">
                    <a class="btn btn-agro btn-block" href="{{ route('news_details', ['id' => $news->id] ?? '#') }}">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

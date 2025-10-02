@extends('home.headerFooter')

@section('title', 'Gallery')

@section('body')
<section class="py-5 text-center bg-light">
    <div class="container">
        <h1 class="fw-bold mb-4 text-success">🌻 Photo Gallery</h1>
        <p class="lead text-muted mb-5">Explore beautiful moments from our farmers, crops, and agriculture events.</p>

        <div class="row g-4">
            @foreach (['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg'] as $img)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <img src="{{ asset('final_eagri/img/'.$img) }}" class="img-fluid rounded" alt="Gallery">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

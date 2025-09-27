@extends('home.headerFooter')

@section('title', 'Gallery')

@section('body')
<section class="py-5 text-center">
    <h1 class="fw-bold mb-4">Photo Gallery</h1>
    <div class="row g-3">
        <div class="col-md-4"><img src="{{ asset('final_eagri/img/1.jpg') }}" class="img-fluid rounded shadow"></div>
        <div class="col-md-4"><img src="{{ asset('final_eagri/img/2.jpg') }}" class="img-fluid rounded shadow"></div>
        <div class="col-md-4"><img src="{{ asset('final_eagri/img/3.jpg') }}" class="img-fluid rounded shadow"></div>
    </div>
</section>
@endsection

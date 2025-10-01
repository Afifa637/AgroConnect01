@extends('home.headerFooter')

@section('title', 'Search Results')

@section('body')
<div class="container py-5">
    <h3 class="mb-4">Search Results for "{{ $query ?? '' }}"</h3>

    @if($results->isEmpty())
        <h5 class="text-muted">No crops found.</h5>
    @else
    <div class="row g-4">
        @foreach($results as $crop)
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="" height="200">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $crop->crop_name }}</h5>
                        <p class="text-muted">{{ Str::limit($crop->crop_description, 60) }}</p>
                        <p><strong>৳{{ $crop->bid_rate }}</strong></p>
                        <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

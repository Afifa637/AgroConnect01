@extends('admin.headerFooter')
@section('title','Search Results')
@section('body')

<h3 class="text-agro mb-3">Search Results</h3>

@if($s->isEmpty())
    <div class="alert alert-warning">No search results found.</div>
@endif

<section class="my-4">
    <div class="row">
        @foreach($s as $crop)
            @php($farmer = App\Models\farmer_register::where('username', $crop->username)->first())
            @if($farmer && $farmer->action == "active")
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="{{ $crop->crop_name }}" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $crop->crop_name }}</h5>
                            <p class="small"><strong>Condition:</strong> {{ $crop->condition }}</p>
                            <p class="small"><strong>Location:</strong> {{ $crop->crop_location }}</p>
                            <p class="small"><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                            <p class="small"><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-agro btn-sm" title="Details">
                                <i class="fas fa-seedling"></i> Details
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

@endsection

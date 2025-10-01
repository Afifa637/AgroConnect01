@extends('home.headerFooter')

@section('title', 'Search Results')

@section('body')
<div class="container py-5">
    <h3 class="mb-4">Search Results</h3>

    @if($s->isEmpty())
        <h5 class="text-muted">No results found for your search.</h5>
    @else
    <div class="row g-4">
        @foreach($s as $crop)
            @php( $farmer = App\Models\farmer_register::where('username',$crop->username)->first())
            @if($farmer && $farmer->action=="active")
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="" height="200">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $crop->crop_name }}</h5>
                            <p class="mb-1">Condition: {{ $crop->condition }}</p>
                            <p class="text-muted">Location: {{ $crop->crop_location }}</p>
                            <p><strong>৳{{ $crop->bid_rate }}</strong></p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-sm btn-primary">Details</a>
                                @if(Session::get('c_username'))
                                    <a href="{{ route('Bid_model',['id'=>$crop->id]) }}" class="btn btn-sm btn-success">Bid</a>
                                    <a href="{{ route('wishlist_db',['id'=>$crop->id]) }}" class="btn btn-sm btn-outline-danger"><i class="far fa-heart"></i></a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-success">Login to Bid</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    @endif
</div>
@endsection

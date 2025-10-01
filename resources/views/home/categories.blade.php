@extends('home.headerFooter')

@section('title', 'Crop Categories')

@section('body')
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($crops as $crop)
                @php( $farmer = App\Models\farmer_register::where('username',$crop->username)->first())
                @if($farmer && $farmer->action=="active")
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="crop" height="200">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $crop->crop_name }}</h5>
                            <p class="text-muted mb-1">Condition: {{ $crop->condition }}</p>
                            <p class="mb-1">Quantity: {{ $crop->crop_quantity }}</p>
                            <p class="mb-1">Bid Rate: <span class="fw-bold text-success">৳{{ $crop->bid_rate }}</span></p>
                            <p class="small text-muted">Ends: {{ $crop->last_date_bidding }}</p>
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
    </div>
</section>
@endsection

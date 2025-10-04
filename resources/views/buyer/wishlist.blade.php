@extends('buyer.headerFooter')

@section('body')
<style>
    .agro-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background: #ffffff;
        transition: transform .3s;
    }
    .agro-card:hover {
        transform: translateY(-5px);
    }
    .item-name {
        background: #2d6a4f;
        color: white;
        padding: 10px;
        font-weight: bold;
        border-radius: 6px 6px 0 0;
    }
</style>

<div class="container my-5">
    <h2 class="text-center text-success mb-4"><i class="fas fa-heart"></i> My Wishlist</h2>

    <div class="row g-4">
        @foreach($wishlists as $wishlist)
        @php($crop = App\Models\crop_import::where('id', $wishlist->crop_id)->first())

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="agro-card">
                <img src="{{url($crop->crop_image)}}" class="img-fluid" alt="{{$crop->crop_name}}" height="200">
                <div class="p-3">
                    <h5 class="item-name">{{$crop->crop_name}}</h5>
                    <p class="text-muted mb-1">Condition: {{$crop->condition}}</p>
                    <p>Quantity: <strong>{{$crop->crop_quantity}}</strong></p>
                    <p>Bid Rate: <span class="text-success fw-bold">{{$crop->bid_rate}} TK</span></p>
                    <p>Finish Date: {{$crop->last_date_bidding}}</p>

                    <div class="d-flex justify-content-between">
                        <a href="{{route('crop_details',['id'=>$crop->id])}}" class="btn btn-outline-success btn-sm">Details</a>
                        <a href="{{route('Bid_model',['id'=>$crop->id])}}" class="btn btn-success btn-sm">Bid Here</a>
                        <a href="{{route('wishlist_remove',['id'=>$wishlist->id])}}" class="btn btn-danger btn-sm">Remove</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

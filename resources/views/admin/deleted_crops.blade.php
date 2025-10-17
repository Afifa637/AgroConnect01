@extends('admin.headerFooter')
@section('title','Deleted Crops')
@section('body')

<h5 class="text-center text-success mb-3">{{ Session::get('msg') }}</h5>

<div class="row">
    @foreach($crops as $crop)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset($crop->crop_image) }}" class="card-img-top" alt="{{ $crop->crop_name }}" style="height:200px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $crop->crop_name }}</h5>
                    <p class="mb-1"><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                    <p class="mb-1"><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                    <p class="mb-1"><strong>Bidding Ends:</strong> {{ $crop->last_date_bidding }}</p>
                </div>
                <div class="card-footer text-center bg-white">
                    <a class="btn btn-agro btn-sm" href="{{ route('crop_details',['id'=>$crop->id]) }}" title="Details"><i class="fas fa-info-circle"></i></a>
                    <a class="btn btn-outline-danger btn-sm" href="{{ route('crop_delete',['id'=>$crop->id]) }}"
                       onclick="return confirm('Are you sure you want to permanently delete this crop?');" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

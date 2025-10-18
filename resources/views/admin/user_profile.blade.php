@extends('admin.headerFooter')
@section('title','User Crops')
@section('body')
<div class="container-fluid py-4">
<style>
    .item-desc { background:#f4fbf4; padding:0.6rem; }
    .item-name { background:#2b8a3e; color:#fff; padding:8px; border-radius:4px; margin-bottom:6px; }
    .crop-img { height:200px; object-fit:cover; width:100%; border-radius:4px; }
</style>

<h2 class="text-agro text-center mb-3">{{ Session::get('c_login') }}</h2>

<section id="menu-section" class="my-4">
    <div class="row">
        @foreach($crops as $record)
            @php($crop = App\Models\CropImport::where('id', $record->crop_id)->first())
            @if($crop)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset($crop->crop_image) }}" class="crop-img card-img-top" alt="{{ $crop->crop_name }}">
                        <div class="card-body item-desc text-center">
                            <h4 class="item-name">{{ $crop->crop_name }}</h4>
                            <p class="mb-1"><strong>Condition:</strong> {{ $crop->condition }}</p>
                            <p class="mb-1"><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                            <p class="mb-1"><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                            <p class="mb-1"><strong>Ends:</strong> {{ $crop->last_date_bidding }}</p>

                            <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-agro btn-block mt-2" target="_blank">
                                <i class="fas fa-info-circle"></i> Details
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
</div>
@endsection

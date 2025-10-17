@extends('admin.headerFooter')
@section('title','Farmer Profile')
@section('body')

<style>
    /* small card tweaks for agro theme */
    .item-desc { background: #f4fbf4; padding: 0.5rem; }
    .item-name { background: #2b8a3e; color: #fff; padding: 8px; margin-bottom: 6px; border-radius:4px; }
    .crop-card img { object-fit: cover; height:200px; width:100%; border-radius:4px; }
</style>

<h2 class="text-agro text-center mb-3">{{ Session::get('fa_login') }}</h2>

<section id="menu-section" class="my-4">
    <div class="row">
        @foreach($crops as $crop)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card crop-card shadow-sm">
                    <img src="{{ url($crop->crop_image) }}" alt="{{ $crop->crop_name }}" class="card-img-top">
                    <div class="card-body item-desc text-center">
                        <h4 class="item-name">{{ $crop->crop_name }}</h4>
                        <p class="mb-1"><strong>Condition:</strong> {{ $crop->condition }}</p>
                        <p class="mb-1"><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                        <p class="mb-1"><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                        <p class="mb-1"><strong>Bidding Ends:</strong> {{ $crop->last_date_bidding }}</p>

                        <a class="btn btn-agro btn-block mt-2" target="_blank" href="{{ route('crop_details',['id'=>$crop->id]) }}">
                            <i class="fas fa-seedling"></i> Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection

@extends('admin.headerFooter')
@section('title','Unpublished Crops')
@section('body')

<section>
    <h5 class="text-center text-success mb-3">{{ Session::get('msg') }}</h5>

    <div class="row my-4">
        @foreach($crops as $crop)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="{{ $crop->crop_name }}" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $crop->crop_name }}</h5>
                        <p class="mb-1"><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                        <p class="mb-1"><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                        <p class="mb-1"><strong>Ends:</strong> {{ $crop->last_date_bidding }}</p>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a class="btn btn-agro btn-sm" target="_blank" href="{{ route('crop_details',['id'=>$crop->id]) }}" title="Details">
                            <i class="fas fa-info-circle"></i>
                        </a>

                        <a class="btn btn-outline-success btn-sm" href="{{ route('crop_published_save',['id'=>$crop->id]) }}"
                           onclick="return confirm('Are you sure you want to publish this crop?');" title="Publish">
                            <i class="fas fa-arrow-circle-up"></i>
                        </a>

                        <a class="btn btn-outline-danger btn-sm" href="{{ route('crop_delete',['id'=>$crop->id]) }}"
                           onclick="return confirm('Are you sure you want to delete this crop?');" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="m-5 float-right text-muted">
    {{-- Optional pagination or debug --}}
    {{ $crops->links ?? '' }}
</section>

@endsection

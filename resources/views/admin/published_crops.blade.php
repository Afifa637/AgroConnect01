@extends('admin.headerFooter')
@section('title','Published Crops')
@section('body')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
.text-agro{color:#2e7d32;font-weight:600;}
.btn-agro{background:#2e7d32;color:#fff;}
.btn-agro:hover{background:#256728;color:#fff;}
</style>
@endpush

<div class="container-fluid py-4">
  <h3 class="text-agro text-center mb-4"><i class="fa-solid fa-wheat-awn"></i> Published Crops</h3>
  <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

  <div class="row my-4">
    @foreach($crops as $crop)
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset($crop->crop_image) }}" class="card-img-top" style="height:200px;object-fit:cover;">
        <div class="card-body">
          <h5 class="card-title text-center">{{ $crop->crop_name }}</h5>
          <p><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
          <p><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
          <p><strong>Ends:</strong> {{ $crop->last_date_bidding }}</p>
        </div>
        <div class="card-footer text-center bg-white">
          <a class="btn btn-agro btn-sm" href="{{ route('crop_details',['id'=>$crop->id]) }}" target="_blank" title="Details">
            <i class="fa-solid fa-circle-info"></i>
          </a>
          <a class="btn btn-outline-warning btn-sm"
             href="{{ route('crop_unpublished_save',['id'=>$crop->id]) }}"
             onclick="return confirm('Unpublish this crop?');" title="Unpublish">
             <i class="fa-solid fa-circle-down"></i>
          </a>
          <a class="btn btn-outline-danger btn-sm"
             href="{{ route('crop_delete',['id'=>$crop->id]) }}"
             onclick="return confirm('Delete this crop?');" title="Delete">
             <i class="fa-solid fa-trash"></i>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="float-end text-muted">
    {{ $crops->links ?? '' }}
  </div>
</div>
@endsection

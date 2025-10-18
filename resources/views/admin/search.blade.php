@extends('admin.headerFooter')
@section('title','Search Results')
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
  <h3 class="text-agro mb-3"><i class="fa-solid fa-search"></i> Search Results</h3>

  @if($s->isEmpty())
    <div class="alert alert-warning">No search results found.</div>
  @endif

  <div class="row my-4">
    @foreach($s as $crop)
      @php($farmer = App\Models\farmer_register::where('username',$crop->username)->first())
      @if($farmer && $farmer->action == "active")
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset($crop->crop_image) }}" class="card-img-top" style="height:200px;object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title">{{ $crop->crop_name }}</h5>
            <p><strong>Condition:</strong> {{ $crop->condition }}</p>
            <p><strong>Location:</strong> {{ $crop->crop_location }}</p>
            <p><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
            <p><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
          </div>
          <div class="card-footer text-center bg-white">
            <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-agro btn-sm">
              <i class="fa-solid fa-seedling"></i> Details
            </a>
          </div>
        </div>
      </div>
      @endif
    @endforeach
  </div>
</div>
@endsection

@extends('farmer.headerFooter')
@section('name','Crop Import')

@section('body')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Success & Error messages --}}
            @if(Session::get('msg'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="fas fa-check-circle"></i> {{ Session::get('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white text-center">
                    <h4><i class="fas fa-seedling"></i> Import Your Crop</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{route('add_product_db')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="username" value="{{Session::get('f_username')}}">

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-leaf"></i> Crop Name</label>
                            <input type="text" name="crop_name" class="form-control" placeholder="Ex: Jute, Rice" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-calendar"></i> Crop Session</label>
                                <select class="form-select" name="crop_session" required>
                                    <option value="">-- Select --</option>
                                    <option value="1">Summer</option>
                                    <option value="2">Winter</option>
                                    <option value="3">Monsoon</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-tags"></i> Crop Type</label>
                                <select class="form-select" name="crop_type" required>
                                    <option value="">-- Select type --</option>
                                    @php($categories=App\Models\categories_info::where('categories_status',1)->get())
                                    @foreach($categories as $categorie)
                                        <option value="{{$categorie->id}}">{{$categorie->categories_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-box"></i> Quantity</label>
                                <input type="text" name="crop_quantity" class="form-control" placeholder="Ex: 50kg, 2 bighas" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Location</label>
                                <input type="text" name="crop_location" class="form-control" placeholder="Ex: Dhaka, Kolabagan" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-hand-holding-usd"></i> Bidding Rate (Tk)</label>
                            <input type="number" name="bid_rate" class="form-control" min="1" placeholder="Starting price" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-align-left"></i> Description</label>
                            <textarea name="crop_description" class="form-control" rows="3" placeholder="Crop details..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-calendar-day"></i> Bidding End Date</label>
                            <input type="date" name="last_date_bidding" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Image 1</label>
                                <input type="file" name="crop_image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Image 2</label>
                                <input type="file" name="crop_image2" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Crop Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

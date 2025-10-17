@extends('farmer.headerFooter')
@section('title','Crop Import')

@section('body')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- ✅ Success & Error messages --}}
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

                    <form method="POST" action="{{ route('crop_store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-user"></i> Farmer Username</label>
                            <input type="text" name="username" class="form-control" 
                                   value="{{ Session::get('f_username') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-leaf"></i> Crop Name</label>
                            <input type="text" name="crop_name" class="form-control" placeholder="Ex: Jute, Rice" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-calendar"></i> Crop Session</label>
                                <select class="form-select" name="crop_session" required>
                                    <option value="">-- Select --</option>
                                    <option value="Summer">Summer</option>
                                    <option value="Winter">Winter</option>
                                    <option value="Monsoon">Monsoon</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-tags"></i> Crop Type</label>
                                <select class="form-select" name="crop_type" required>
                                    <option value="">-- Select type --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categories_name }}</option>
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
                                <div class="input-group">
                                    <input type="text" id="crop_location" name="crop_location" class="form-control" placeholder="Ex: Dhaka, Kolabagan" required>
                                    <button class="btn btn-outline-success" type="button" id="getLocation"><i class="fas fa-location-crosshairs"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-hand-holding-usd"></i> Bidding Rate (Tk)</label>
                                <input type="number" name="bid_rate" class="form-control" min="1" placeholder="Starting price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-clock"></i> Bidding Duration</label>
                                <select class="form-select" id="bid_duration">
                                    <option value="">-- Select Duration --</option>
                                    <option value="3">3 Days</option>
                                    <option value="7">7 Days</option>
                                    <option value="14">14 Days</option>
                                </select>
                                <input type="hidden" name="last_date_bidding" id="last_date_bidding">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-align-left"></i> Description</label>
                            <textarea name="crop_description" class="form-control" rows="3" placeholder="Crop details..." required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Image 1</label>
                                <input type="file" name="crop_image" id="crop_image" class="form-control" accept="image/*" required>
                                <img id="preview1" class="img-thumbnail mt-2" style="max-height:120px; display:none;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Image 2</label>
                                <input type="file" name="crop_image2" id="crop_image2" class="form-control" accept="image/*" required>
                                <img id="preview2" class="img-thumbnail mt-2" style="max-height:120px; display:none;">
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

{{-- 🌍 Auto Location & Image Preview Script --}}
<script>
document.getElementById('getLocation').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('crop_location').value =
                `Lat: ${position.coords.latitude.toFixed(4)}, Lng: ${position.coords.longitude.toFixed(4)}`;
        }, function() {
            alert('Unable to fetch location.');
        });
    } else {
        alert('Geolocation not supported.');
    }
});

function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

document.getElementById('crop_image').addEventListener('change', e => previewImage(e.target, 'preview1'));
document.getElementById('crop_image2').addEventListener('change', e => previewImage(e.target, 'preview2'));

document.getElementById('bid_duration').addEventListener('change', function() {
    const days = parseInt(this.value);
    if (days) {
        const future = new Date();
        future.setDate(future.getDate() + days);
        document.getElementById('last_date_bidding').value = future.toISOString().split('T')[0];
    }
});
</script>
@endsection

@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                {{-- Header --}}
                <div class="card-header bg-gradient bg-success text-white py-3 d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fas fa-leaf me-2"></i>Edit Crop Details</h4>
                    <a href="{{ route('crop_manage') }}" class="btn btn-light btn-sm shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Edit Form --}}
                    <form action="{{ route('crop_update', $crop->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Crop Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-seedling me-2"></i>Crop Name
                                </label>
                                <input type="text" class="form-control shadow-sm" name="crop_name"
                                       value="{{ old('crop_name', $crop->crop_name) }}" required>
                            </div>

                            {{-- Crop Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-tags me-2"></i>Crop Type
                                </label>
                                <input type="text" class="form-control shadow-sm" name="crop_type"
                                       value="{{ old('crop_type', $crop->crop_type) }}" required>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-info">
                                    <i class="fas fa-balance-scale me-2"></i>Quantity (kg)
                                </label>
                                <input type="number" class="form-control shadow-sm" name="crop_quantity"
                                       value="{{ old('crop_quantity', $crop->crop_quantity) }}" min="1" required>
                            </div>

                            {{-- Auto Location --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-map-marker-alt me-2"></i>Crop Location
                                    <button type="button" class="btn btn-sm btn-outline-success ms-2" id="detectLocation">
                                        <i class="fas fa-location-arrow"></i> Detect
                                    </button>
                                </label>
                                <input type="text" class="form-control shadow-sm" id="cropLocation" name="crop_location"
                                       value="{{ old('crop_location', $crop->crop_location) }}" required>
                            </div>

                            {{-- Bid Rate --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-warning">
                                    <i class="fas fa-dollar-sign me-2"></i>Bid Rate (৳)
                                </label>
                                <input type="number" class="form-control shadow-sm" name="bid_rate"
                                       value="{{ old('bid_rate', $crop->bid_rate) }}" required>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <textarea class="form-control shadow-sm" name="crop_description" rows="4" required>{{ old('crop_description', $crop->crop_description) }}</textarea>
                            </div>

                            {{-- Bid Duration --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-clock me-2"></i>Bid Duration
                                </label>
                                <select class="form-select shadow-sm" name="bid_duration" id="bidDuration">
                                    <option value="">Select Duration</option>
                                    <option value="7" {{ $crop->bid_duration == 7 ? 'selected' : '' }}>7 Days</option>
                                    <option value="14" {{ $crop->bid_duration == 14 ? 'selected' : '' }}>14 Days</option>
                                    <option value="21" {{ $crop->bid_duration == 21 ? 'selected' : '' }}>21 Days</option>
                                </select>
                            </div>

                            {{-- Last Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-calendar me-2"></i>Last Date for Bidding
                                </label>
                                <input type="date" class="form-control shadow-sm" name="last_date_bidding"
                                       value="{{ old('last_date_bidding', $crop->last_date_bidding) }}" required>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-toggle-on me-2"></i>Status
                                </label>
                                <select class="form-select shadow-sm" name="status">
                                    <option value="1" {{ $crop->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $crop->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- Image 1 with Preview --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-image me-2"></i>Crop Image 1
                                </label>
                                <input type="file" class="form-control shadow-sm" name="crop_image" id="cropImage1" accept="image/*">
                                <div class="mt-2">
                                    <img src="{{ url($crop->crop_image) }}" id="previewImage1" class="img-thumbnail shadow-sm" width="120" alt="Crop Image 1">
                                </div>
                            </div>

                            {{-- Image 2 with Preview --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-image me-2"></i>Crop Image 2
                                </label>
                                <input type="file" class="form-control shadow-sm" name="crop_image2" id="cropImage2" accept="image/*">
                                <div class="mt-2">
                                    <img src="{{ url($crop->crop_image2) }}" id="previewImage2" class="img-thumbnail shadow-sm" width="120" alt="Crop Image 2">
                                </div>
                            </div>

                        </div>

                        {{-- Submit Buttons --}}
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i>Update Crop
                            </button>
                            <a href="{{ route('crop_manage') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Image Preview & Location Script --}}
<script>
    // Live preview for image inputs
    function previewImage(inputId, previewId) {
        document.getElementById(inputId).addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    previewImage('cropImage1', 'previewImage1');
    previewImage('cropImage2', 'previewImage2');

    // Detect location automatically
    document.getElementById('detectLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cropLocation').value = data.display_name || 'Location not found';
                    });
            }, () => alert('Unable to fetch location.'));
        } else {
            alert('Geolocation not supported in this browser.');
        }
    });
</script>

@endsection

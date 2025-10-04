@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Crop</h4>
                </div>
                <div class="card-body">

                    {{-- Success & Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
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

                    <form action="{{ route('crop_update', $crop->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-seedling me-2 text-success"></i>Crop Name
                                </label>
                                <input type="text" class="form-control" name="crop_name" 
                                       value="{{ old('crop_name', $crop->crop_name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tags me-2 text-primary"></i>Crop Type
                                </label>
                                <input type="text" class="form-control" name="crop_type" 
                                       value="{{ old('crop_type', $crop->crop_type) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-balance-scale me-2 text-info"></i>Quantity
                                </label>
                                <input type="text" class="form-control" name="crop_quantity" 
                                       value="{{ old('crop_quantity', $crop->crop_quantity) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>Crop Location
                                </label>
                                <input type="text" class="form-control" name="crop_location" 
                                       value="{{ old('crop_location', $crop->crop_location) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-2 text-warning"></i>Bid Rate (৳)
                                </label>
                                <input type="number" class="form-control" name="bid_rate" 
                                       value="{{ old('bid_rate', $crop->bid_rate) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-align-left me-2 text-secondary"></i>Description
                                </label>
                                <textarea class="form-control" name="crop_description" rows="4" required>{{ old('crop_description', $crop->crop_description) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Last Date for Bidding
                                </label>
                                <input type="date" class="form-control" name="last_date_bidding" 
                                       value="{{ old('last_date_bidding', $crop->last_date_bidding) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-toggle-on me-2 text-success"></i>Status
                                </label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ $crop->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $crop->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-image me-2 text-danger"></i>Crop Image 1
                                </label>
                                <input type="file" class="form-control" name="crop_image">
                                @if($crop->crop_image)
                                    <div class="mt-2">
                                        <img src="{{ url($crop->crop_image) }}" class="img-thumbnail" width="120" alt="Crop Image">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-image me-2 text-danger"></i>Crop Image 2
                                </label>
                                <input type="file" class="form-control" name="crop_image2">
                                @if($crop->crop_image2)
                                    <div class="mt-2">
                                        <img src="{{ url($crop->crop_image2) }}" class="img-thumbnail" width="120" alt="Crop Image 2">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Crop
                            </button>
                            <a href="{{ route('crop_manage') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

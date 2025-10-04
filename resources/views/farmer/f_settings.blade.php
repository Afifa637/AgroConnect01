@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-user-cog me-2"></i> Farmer Settings</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <ul class="nav nav-pills mb-3" id="settingsTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#profile">
                        <i class="fas fa-id-card me-1"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#updateprofile">
                        <i class="fas fa-user-edit me-1"></i> Update Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#verification">
                        <i class="fas fa-check-circle me-1"></i> Verification
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- PROFILE INFO --}}
                <div id="profile" class="tab-pane fade show active">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold text-success mb-3">Profile Details</h5>
                            <table class="table table-striped table-bordered">
                                <tr><th>Name</th><td>{{ $user->username }}</td></tr>
                                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                                <tr><th>Mobile</th><td>{{ $user->mobile }}</td></tr>
                                <tr><th>Date of Birth</th><td>{{ $user->dob }}</td></tr>
                                <tr><th>Division</th><td>{{ $user->division }}</td></tr>
                                <tr><th>Address</th><td>{{ $user->address }}</td></tr>
                                <tr><th>Zip Code</th><td>{{ $user->zip_code }}</td></tr>
                                <tr><th>Gender</th><td>{{ $user->gender }}</td></tr>
                                <tr>
                                    <th>Profile Picture</th>
                                    <td><img src="{{ asset($user->profile_pic ?? 'default.png') }}" width="120" class="img-thumbnail"></td>
                                </tr>
                                <tr><th>Created At</th><td>{{ $user->created_at }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- UPDATE PROFILE --}}
                <div id="updateprofile" class="tab-pane fade">
                    <div class="card shadow-sm border-0 p-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-user-edit me-1"></i> Update Profile
                        </h5>

                        <form action="{{ route('update_farmer') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" value="{{ $user->username }}" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ $user->dob }}" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Division</label>
                                    <select name="division" class="form-control" required>
                                        <option value="{{ $user->division }}">{{ $user->division }}</option>
                                        <option>Dhaka</option>
                                        <option>Rajshahi</option>
                                        <option>Khulna</option>
                                        <option>Chittagong</option>
                                        <option>Barishal</option>
                                        <option>Comilla</option>
                                        <option>Rangpur</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Zip Code</label>
                                    <input type="number" name="zip_code" value="{{ $user->zip_code }}" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" value="{{ $user->address }}" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control">
                                    <img src="{{ asset($user->profile_pic ?? 'default.png') }}" class="mt-2 img-thumbnail" width="120">
                                </div>
                            </div>

                            <button class="btn btn-success mt-3"><i class="fas fa-save me-1"></i> Save Changes</button>
                        </form>
                    </div>
                </div>

                {{-- NID VERIFICATION --}}
                <div id="verification" class="tab-pane fade">
                    <div class="card shadow-sm border-0 p-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-check-circle me-1"></i> NID Verification
                        </h5>

                        <form action="{{ route('NID_verification') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">NID Front</label>
                                <input type="file" name="nid_image" class="form-control" required>
                                @if($user->NID_1)
                                    <img src="{{ asset($user->NID_1) }}" class="img-thumbnail mt-2" width="250">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NID Back</label>
                                <input type="file" name="nid_image2" class="form-control" required>
                                @if($user->NID_2)
                                    <img src="{{ asset($user->NID_2) }}" class="img-thumbnail mt-2" width="250">
                                @endif
                            </div>

                            <button class="btn btn-success"><i class="fas fa-check me-1"></i> Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

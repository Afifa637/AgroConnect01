@extends('buyer.headerFooter')
@section('body')

<style>
    .settings-container {
        background: #f7fdf8;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-top: 3rem;
    }
    .nav-pills .nav-link.active {
        background: #4caf50;
    }
    .table th {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .btn-success {
        background-color: #43a047 !important;
        border: none;
    }
</style>

<div class="container settings-container">
    <ul class="nav nav-pills justify-content-center mb-4">
        <li class="nav-item"><a data-bs-toggle="pill" class="nav-link active" href="#profile">Profile Details</a></li>
        <li class="nav-item"><a data-bs-toggle="pill" class="nav-link" href="#updateprofile">Update Profile</a></li>
        <li class="nav-item"><a data-bs-toggle="pill" class="nav-link" href="#verification">Verification</a></li>
    </ul>

    <div class="tab-content">
        {{-- Profile Tab --}}
        <div id="profile" class="tab-pane fade show active">
            <h3 class="text-center text-success mb-4">Profile Details</h3>
            <table class="table table-bordered text-center">
                <tr><th>Name</th><td>{{$user->username}}</td></tr>
                <tr><th>Email</th><td>{{$user->email}}</td></tr>
                <tr><th>Mobile</th><td>{{$user->mobile}}</td></tr>
                <tr><th>Date of Birth</th><td>{{$user->dob}}</td></tr>
                <tr><th>Division</th><td>{{$user->division}}</td></tr>
                <tr><th>Address</th><td>{{$user->address}}</td></tr>
                <tr><th>Zip Code</th><td>{{$user->zip_code}}</td></tr>
                <tr><th>Gender</th><td>{{$user->gender}}</td></tr>
                <tr><th>Profile Picture</th><td><img src="{{url($user->profile_pic)}}" height="180" class="rounded"></td></tr>
                <tr><th>Joined</th><td>{{$user->created_at}}</td></tr>
            </table>
        </div>

        {{-- Update Profile Tab --}}
        <div id="updateprofile" class="tab-pane fade">
            <div class="col-lg-8 mx-auto">
                <form action="{{route('customerRegisterUpdate')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h3 class="text-center text-success mb-3">Edit Your Information</h3>
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="mb-3"><label>Mobile</label>
                        <input type="tel" name="mobile" class="form-control" value="{{$user->mobile}}">
                    </div>
                    <div class="mb-3"><label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{$user->dob}}">
                    </div>
                    <div class="mb-3"><label>Division</label>
                        <select class="form-control" name="division">
                            <option>{{$user->division}}</option>
                            <option>Dhaka</option><option>Rajshahi</option>
                            <option>Khulna</option><option>Chittagong</option>
                            <option>Barishal</option><option>Comilla</option><option>Rangpur</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{$user->address}}">
                    </div>
                    <div class="mb-3"><label>Zip Code</label>
                        <input type="number" name="zip_code" class="form-control" value="{{$user->zip_code}}">
                    </div>
                    <div class="mb-3"><label>Gender</label>
                        <div>
                            <label><input type="radio" name="gender" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}> Male</label>
                            <label class="ms-3"><input type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}> Female</label>
                        </div>
                    </div>
                    <div class="mb-3"><label>Profile Image</label>
                        <input type="file" name="profile_image" class="form-control">
                    </div>
                    <button class="btn btn-success w-100 mt-3">Update Profile</button>
                </form>
            </div>
        </div>

        {{-- Verification Tab --}}
        <div id="verification" class="tab-pane fade">
            <div class="col-lg-6 mx-auto mt-3">
                <h3 class="text-center text-success mb-3">NID Verification</h3>
                <form action="{{route('NID_verification')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>NID Front</label>
                        <input type="file" name="nid_image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>NID Back</label>
                        <input type="file" name="nid_image2" class="form-control">
                    </div>
                    <button class="btn btn-success w-100">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.headerFooter')
@section('title','Admin Settings')
@section('body')

<section>
    <div class="container my-5">
        <div class="other-section">
            <ul class="nav nav-pills mb-3">
                <li class="nav-item"><a data-toggle="pill" class="nav-link active p-3" href="#profile">Profile Details</a></li>
                <li class="nav-item"><a data-toggle="pill" class="nav-link p-3" href="#updateprofile">Update Profile</a></li>
            </ul>

            <div class="tab-content">
                <div id="profile" class="tab-pane active">
                    <div class="col-md-12">
                        <h3 class="text-center text-agro">Profile Details</h3>
                        <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

                        <table class="table table-bordered mt-3">
                            <tr><th>Name</th><td>{{ $user->username }}</td></tr>
                            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                            <tr><th>Mobile</th><td>{{ $user->mobile }}</td></tr>
                            <tr><th>Date of Birth</th><td>{{ $user->dob }}</td></tr>
                            <tr><th>Division</th><td>{{ $user->division }}</td></tr>
                            <tr><th>Address</th><td>{{ $user->address }}</td></tr>
                            <tr><th>Gender</th><td>{{ $user->gender }}</td></tr>
                            <tr><th>Profile Pic</th><td><img src="{{ url($user->profile_pic) }}" alt="profile" height="150" width="150"></td></tr>
                            <tr><th>Created At</th><td>{{ $user->created_at }}</td></tr>
                        </table>
                    </div>
                </div>

                <div id="updateprofile" class="tab-pane">
                    <div class="col-lg-8 mx-auto">
                        <form action="{{ route('adminregisterUpdate') }}" method="POST" enctype="multipart/form-data" class="form-group">
                            @csrf
                            <h3 class="text-center text-agro mb-3">Edit Profile</h3>

                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="tel" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
                                <span class="text-danger">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                            </div>

                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ $user->dob }}" required>
                            </div>

                            <div class="form-group">
                                <label>Division</label>
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

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $user->address }}" required>
                            </div>

                            <div class="form-group">
                                <label>Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}> Male
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}> Female
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Profile image</label>
                                <input type="file" name="profile_image" accept="image/*" class="form-control-file">
                                <span class="text-danger">{{ $errors->has('profile_image') ? $errors->first('profile_image') : '' }}</span>
                            </div>

                            <div class="form-group mt-3">
                                <button class="btn btn-agro btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section>

@endsection

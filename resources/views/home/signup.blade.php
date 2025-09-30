@extends('home.headerFooter')

@section('title', 'Register - AgroConnect')

@section('body')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">
            <div class="card shadow border-success">
                <div class="card-header bg-success text-white text-center">
                    <h3>Welcome To AgroConnect</h3>
                    <small>Farmer for selling crops, Buyer for bidding & buying</small>
                    @if(Session::has('reg_success'))
                        <div class="alert alert-success mt-2">{{ Session::get('reg_success') }}</div>
                    @endif
                    @if(Session::has('login_error'))
                        <div class="alert alert-danger mt-2">{{ Session::get('login_error') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('registerSave') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Register As</label>
                            <select id="role" name="register_as" class="form-select" required>
                                <option value="">-- Select Role --</option>
                                <option value="farmer">Farmer</option>
                                <option value="customer">Buyer</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('register_as') }}</span>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   id="username" name="username" value="{{ old('username') }}" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                   id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                   id="dob" name="dob" value="{{ old('dob') }}" required>
                            @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Division -->
                        <div class="mb-3">
                            <label for="division" class="form-label">Division</label>
                            <select class="form-select" name="division" required>
                                <option value="">-- Select Division --</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Comilla">Comilla</option>
                                <option value="Rangpur">Rangpur</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('division') }}</span>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   id="address" name="address" value="{{ old('address') }}" required>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Zip Code -->
                        <div class="mb-3">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                   id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                            @error('zip_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                                <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                            </select>
                            @error('gender') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirm"
                                   name="password_confirm" required>
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                        </div>

                        <!-- NID -->
                        <div class="mb-3">
                            <label for="nid1" class="form-label">NID Front</label>
                            <input type="file" class="form-control" id="nid1" name="NID_1">
                        </div>
                        <div class="mb-3">
                            <label for="nid2" class="form-label">NID Back</label>
                            <input type="file" class="form-control" id="nid2" name="NID_2">
                        </div>

                        <!-- Submit -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            Already have an account? <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Login</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('home.headerFooter')

@section('title', 'Register')

@section('body')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">

                <h3 class="text-center mb-4">Register</h3>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Register As</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="farmer">Farmer</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
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
                        <label for="email" class="form-label">Email Address</label>
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

                    <!-- DOB -->
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                               id="dob" name="dob" value="{{ old('dob') }}" required>
                        @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Division -->
                    <div class="mb-3">
                        <label for="division" class="form-label">Division</label>
                        <input type="text" class="form-control @error('division') is-invalid @enderror"
                               id="division" name="division" value="{{ old('division') }}" required>
                        @error('division') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <option value="male">Male</option>
                            <option value="female">Female</option>
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
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" required>
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
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success px-4">Register</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

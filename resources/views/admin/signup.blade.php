@extends('admin.headerFooter')
@section('title','Register Admin')
@section('body')

<section class="my-4">
    <div class="col-lg-6 mx-auto">
        <div class="jumbotron shadow-sm">
            <h2 class="text-agro text-center mb-3">Register Admin</h2>

            <form action="{{ route('admin_registerSave') }}" method="POST" class="form-group">
                @csrf

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="username" required>
                    <span class="text-danger">{{ $errors->has('username') ? $errors->first('username') : '' }}</span>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                </div>

                <div class="form-group">
                    <label>Mobile</label>
                    <input type="tel" name="mobile" class="form-control" placeholder="8801xxxxxxxxx" required>
                    <span class="text-danger">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Division</label>
                    <select class="form-control" name="division" required>
                        <option value="">-- Select Division --</option>
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
                    <input type="text" name="address" class="form-control" placeholder="1234 Main St" required>
                </div>

                <div class="form-group">
                    <label>Gender</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="male" checked> Male
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="female"> Female
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <span class="text-danger">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                </div>

                <div class="form-group">
                    <label>Password (Confirm)</label>
                    <input type="password" name="password_confirm" class="form-control" required>
                    <span class="text-danger">{{ $errors->has('password_confirm') ? $errors->first('password_confirm') : '' }}</span>
                </div>

                <div class="form-group mt-3">
                    <button class="btn btn-agro btn-block">Sign Up</button>
                </div>
            </form>

            <div class="text-center mt-2">
                <span>Have an account?</span>
                <a href="{{ route('admin.login.page') }}" class="btn btn-link">Login</a>
            </div>
        </div>
    </div>
</section>

@endsection

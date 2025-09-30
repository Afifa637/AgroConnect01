@extends('home.headerFooter')

@section('title', 'Login - AgroConnect')

@section('body')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Alert messages -->
            @if(Session::has('reg_success'))
                <div class="alert alert-success text-center">
                    {{ Session::get('reg_success') }}
                </div>
            @endif

            @if(Session::has('login_error'))
                <div class="alert alert-danger text-center">
                    {{ Session::get('login_error') }}
                </div>
            @endif

            <!-- Card Form -->
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white text-center">
                    <h3>Login to AgroConnect</h3>
                    <small>Farmer for selling crops, Buyer for bidding & buying</small>
                </div>
                <div class="card-body">

                    <form action="{{ route('login_check') }}" method="POST">
                        @csrf

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="register_as" class="form-label">Login As</label>
                            <select name="register_as" id="register_as" class="form-select" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="farmer">Farmer</option>
                                <option value="customer">Buyer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('register_as')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter your email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter your password" required>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember Me</label>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-success px-4">Login</button>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#ForgotPasswordModal">Forgot Password?</button>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-center">
                    <span>Don't have an account?</span>
                    <a href="{{ route('signup') }}" class="btn btn-outline-success btn-sm">Sign Up</a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="ForgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Forgot Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pw_change_link') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="role_fp" class="form-label">Role As</label>
                        <select name="register_as" id="role_fp" class="form-select" required>
                            <option value="" disabled selected>Select your role</option>
                            <option value="farmer">Farmer</option>
                            <option value="customer">Buyer</option>
                        </select>
                        @error('register_as')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email_fp" class="form-label">Email</label>
                        <input type="email" name="email" id="email_fp" class="form-control"
                            placeholder="Enter your email" required>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

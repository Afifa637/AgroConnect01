@extends('home.headerFooter')

@section('title', 'Login')

@section('body')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">

                <h3 class="text-center mb-4">Login</h3>

                @if (session('status'))
                    <div class="alert alert-success mb-3">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Login As</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="farmer">Farmer</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary px-4">Log in</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@extends('home.headerFooter')

@section('title', 'Reset Password')

@section('body')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if(Session::has('login_error'))
                <div class="alert alert-danger text-center">
                    {{ Session::get('login_error') }}
                </div>
            @endif

            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white text-center">
                    <h3>Reset Your Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pass_change_save', ['role' => $role, 'email' => $email]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Enter new password" required>
                            <small class="text-muted">
                                Password must include uppercase, lowercase, and a number.
                            </small>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control"
                                   placeholder="Confirm your password" required>
                            @error('password_confirm')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">Change Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

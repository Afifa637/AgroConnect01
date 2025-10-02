@extends('farmer.headerFooter')

@section('title', 'Confirmation Form')

@section('body')
<div class="container my-5">
    <div class="col-lg-7 mx-auto">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0">Confirm Payment</h3>
            </div>
            <div class="card-body p-4">

                @if(Session::has('msg'))
                    <div class="alert alert-success text-center">{{ Session::get('msg') }}</div>
                @endif

                <form action="{{ route('pay_confirm_message') }}" method="post">
                    @csrf

                    <input type="hidden" name="crop_id" value="{{ $bid->crop_id }}">
                    <input type="hidden" name="f_username" value="{{ $bid->f_username }}">
                    <input type="hidden" name="crop_name" value="{{ $bid->crop_name }}">
                    <input type="hidden" name="cust_username" value="{{ $bid->cust_username }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Account Type</label>
                        <select class="form-select" name="account_type" required>
                            <option value="">— Select a type —</option>
                            <option value="bkash">Bkash</option>
                            <option value="rocket">Rocket</option>
                            <option value="nagad">Nagad</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Account ID</label>
                        <input type="tel" name="account_id" class="form-control" placeholder="Ex: 018********" required>
                        @error('account_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirm Price</label>
                        <input type="number" name="confirm_price" class="form-control" placeholder="Enter confirmed price" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Message (Optional)</label>
                        <input type="text" name="message" class="form-control" placeholder="Enter message (if any)">
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check-circle"></i> Submit Confirmation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

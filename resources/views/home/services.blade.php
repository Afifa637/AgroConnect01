@extends('home.headerFooter')

@section('title', 'Services')

@section('body')
<section class="py-5 text-center bg-light">
    <div class="container">
        <h1 class="fw-bold mb-4 text-success">🌾 Our Services</h1>
        <p class="lead text-muted">Bridging the gap between <strong>farmers</strong> and <strong>buyers</strong> with digital agriculture solutions.</p>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-tractor fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">For Farmers</h5>
                        <p>Farmers can register, post crops, and sell directly without middlemen, ensuring fair profit.</p>
                        <a href="{{ route('signup') }}" class="btn btn-outline-success rounded-pill btn-sm">Join as Farmer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">For Buyers</h5>
                        <p>Buyers and wholesalers can bid on crops directly from farmers, ensuring transparency.</p>
                        <a href="{{ route('signup') }}" class="btn btn-outline-primary rounded-pill btn-sm">Join as Buyer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body">
                        <i class="fas fa-globe fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Marketplace</h5>
                        <p>A secure, transparent, and modern bidding system that ensures fairness and accessibility.</p>
                        <a href="{{ route('news_info') }}" class="btn btn-outline-danger rounded-pill btn-sm">See News</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

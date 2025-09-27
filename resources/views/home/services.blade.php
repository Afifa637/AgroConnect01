@extends('home.headerFooter')

@section('title', 'Services')

@section('body')
<section class="py-5 text-center">
    <h1 class="fw-bold mb-4">Our Services</h1>
    <p class="lead text-muted">We provide a simple way for farmers and buyers to connect.</p>

    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-tractor fa-3x text-success mb-3"></i>
                    <h5>For Farmers</h5>
                    <p>Sell your crops directly to buyers without middlemen.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                    <h5>For Buyers</h5>
                    <p>Find fresh products directly from trusted farmers.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-globe fa-3x text-danger mb-3"></i>
                    <h5>Marketplace</h5>
                    <p>Transparent and fair system with no hidden fees.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

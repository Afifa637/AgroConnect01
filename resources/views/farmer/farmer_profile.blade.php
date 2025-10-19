@extends('farmer.headerFooter')
@section('body')
<style>
    /* profile section */
    .profile-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 40px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .profile-card h4 {
        color: green;
        font-weight: 700;
        margin-bottom: 20px;
    }
    /* crops section */
    #menu-section {
        padding: 1%;
    }
    .card-body {
        text-align: center;
    }
    .item-desc {
        background: rgb(165, 164, 164);
        border-radius: 0 0 10px 10px;
    }
    .item-name {
        background: green;
        color: white;
        padding: 10px;
        border-radius: 10px 10px 0 0;
    }
    .item-desc > p {
        font-size: 0.8rem;
        padding: 5px;
        font-weight: bold;
    }
    .card {
        transition: .4s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>
<div class="container my-5">
    {{-- ================= FARMER INFO ================= --}}
    <div class="profile-card">
        <h4><i class="fas fa-user me-2"></i>Farmer Profile</h4>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ asset($user->profile_pic ?? 'default.png') }}" class="img-thumbnail rounded-circle" width="150">
            </div>
            <div class="col-md-9">
                <table class="table table-borderless mb-0">
                    <tr><th>Name:</th><td>{{ $user->username ?? 'N/A'}}</td></tr>
                    <tr><th>Email:</th><td>{{ $user->email ?? 'N/A'}}</td></tr>
                    <tr><th>Mobile:</th><td>{{ $user->mobile }}</td></tr>
                    <tr><th>Division:</th><td>{{ $user->division }}</td></tr>
                    <tr><th>Address:</th><td>{{ $user->address }}</td></tr>
                    <tr><th>Joined:</th><td>{{ $user->created_at->format('d M, Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

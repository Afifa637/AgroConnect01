@extends('buyer.headerFooter')

@section('body')
<style>
    body {
        background: #f9fdf9;
    }
    .notification-card {
        background: linear-gradient(145deg, #e8f5e9, #f1f8e9);
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        padding: 2rem;
        max-width: 650px;
        margin: 4rem auto;
        text-align: center;
        color: #2e7d32;
    }
    .notification-card h2 {
        font-weight: 700;
        color: #1b5e20;
    }
    .notification-card p {
        font-size: 1rem;
        margin: .3rem 0;
    }
    .notification-card a {
        color: #ffffff;
        background: #43a047;
        padding: .5rem 1rem;
        border-radius: 10px;
        text-decoration: none;
    }
</style>

<div class="notification-card">
    <h2>🌾 Confirmation from {{ $val['f_username'] }}</h2>
    <hr>
    <p><strong>Crop Name:</strong> {{$val['crop_name']}}</p>
    <p><strong>Confirmation Price:</strong> {{$val['confirm_price']}} TK</p>
    <p><strong>Account Type:</strong> {{$val['account_type']}}</p>
    <p><strong>Account ID:</strong> {{$val['account_id']}}</p>
    <br>
    <p>For more details, login to your account:</p>
    <a href="{{route('home')}}">Visit GreenLife</a>
    <br><br>
    <h5>Thank you, {{$val['cust_username']}} 🌱</h5>
</div>
@endsection

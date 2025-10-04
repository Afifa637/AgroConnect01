@extends('buyer.headerFooter')
@section('body')
<style>
    .table th {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .card {
        background: #fdfdfd;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 1rem;
    }
</style>

<div class="container my-5">
@if($pay_confirms->isEmpty())
    <div class="alert alert-warning text-center">🌱 No confirm messages found.</div>
@else
    <div class="card">
        <h3 class="text-center text-success mb-4">Payment Confirmation Info</h3>
        <table class="table table-bordered text-center table-hover">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Crop</th>
                    <th>Farmer</th>
                    <th>Type</th>
                    <th>Account ID</th>
                    <th>Price</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @php($i=1)
            @foreach($pay_confirms as $confirms)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$confirms->crop_name}}</td>
                    <td><a href="{{route('farm_profile',['f_username'=>$confirms->f_username])}}" class="text-success">{{$confirms->f_username}}</a></td>
                    <td>{{$confirms->account_type}}</td>
                    <td>{{$confirms->account_id}}</td>
                    <td>{{$confirms->confirm_price}}</td>
                    <td>{{$confirms->message}}</td>
                    <td>
                        <a href="{{route('crop_details',['id'=>$confirms->crop_id])}}" class="btn btn-outline-success btn-sm"><i class="fas fa-info-circle"></i></a>
                        <a href="{{route('pay_confirm_download_invoice',['id'=>$confirms->id])}}" class="btn btn-outline-success btn-sm"><i class="fas fa-cloud-download-alt"></i></a>
                        <a href="{{route('payment_form',['id'=>$confirms->id])}}" class="btn btn-success btn-sm"><i class="fab fa-amazon-pay"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
@endsection

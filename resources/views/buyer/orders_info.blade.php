@extends('buyer.headerFooter')

@section('body')
<style>
    .agro-card {
        background: #f9fff8;
        border: 1px solid #cdeac0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        border-radius: 10px;
    }
    .agro-header {
        color: #2d6a4f;
        font-weight: bold;
    }
    .agro-table th {
        background-color: #95d5b2;
        color: #fff;
    }
    .agro-table td {
        background-color: #f4fff7;
    }
    .agro-table tr:hover td {
        background-color: #d8f3dc;
    }
</style>

<div class="container my-5">
    <div class="agro-card p-4">
        <h2 class="text-center agro-header mb-4"><i class="fas fa-shopping-basket"></i> My Orders</h2>

        <table class="table table-bordered table-hover text-center agro-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Farmer</th>
                    <th>Customer</th>
                    <th>Crop ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Amount (৳)</th>
                    <th>Transaction ID</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @php($i=1)
                @foreach($orders as $order)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$order->f_username}}</td>
                    <td>{{$order->c_username}}</td>
                    <td>{{$order->crop_id}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->phone}}</td>
                    <td class="fw-bold text-success">{{$order->amount}}</td>
                    <td>{{$order->transaction_id}}</td>
                    <td>
                        <a target="_blank" href="{{route('order_download_invoice',['id'=>$order->id])}}" class="btn btn-success btn-sm shadow-sm">
                            <i class="fas fa-cloud-download-alt"></i> Download
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

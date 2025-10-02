@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <h3 class="mb-4"><i class="fas fa-shopping-cart"></i> Orders</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Customer</th>
                        <th>Bid Price</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $order->crop_name }}</td>
                        <td>{{ $order->cust_name }}</td>
                        <td><span class="badge bg-info">{{ $order->bid_price }} Tk</span></td>
                        <td>{{ Str::limit($order->message,40) }}</td>
                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                        <td>
                            <a href="{{ route('order_show',['id'=>$order->id]) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('order_invoice',['id'=>$order->id]) }}" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Download Invoice">
                                <i class="fas fa-cloud-download-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $orders }}
            </div>
        </div>
    </div>
</div>

@endsection

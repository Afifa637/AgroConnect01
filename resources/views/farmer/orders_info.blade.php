@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Orders Info</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Farmer</th>
                        <th>Customer</th>
                        <th>Crop ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount (৳)</th>
                        <th>Transaction</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><span class="fw-bold">{{ $order->f_username }}</span></td>
                        <td>{{ $order->c_username }}</td>
                        <td><span class="badge bg-info">{{ $order->crop_id }}</span></td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td class="fw-bold text-success">{{ $order->amount }}</td>
                        <td><span class="badge bg-secondary">{{ $order->transaction_id }}</span></td>
                        <td>
                            <a target="_blank" href="{{ route('order_download_invoice',['id'=>$order->id]) }}" 
                               class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Download Invoice">
                                <i class="fas fa-file-download"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

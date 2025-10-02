@extends('farmer.headerFooter')

@section('title', 'Confirm Crops')

@section('body')
<div class="container my-5">

    @if($pay_confirms->isEmpty())
        <div class="alert alert-warning text-center p-4 rounded shadow-sm">
            <h4 class="mb-0">No confirm messages found</h4>
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0">Payment Confirmation Info</h3>
            </div>
            <div class="card-body">
                @if(Session::has('msg'))
                    <div class="alert alert-success text-center">{{ Session::get('msg') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Crop Name</th>
                                <th>Buyer</th>
                                <th>Payment Type</th>
                                <th>Account ID</th>
                                <th>Confirmed Price</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach($pay_confirms as $confirms)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $confirms->crop_name }}</td>
                                    <td>{{ $confirms->cust_username }}</td>
                                    <td><span class="badge bg-primary text-capitalize">{{ $confirms->account_type }}</span></td>
                                    <td>{{ $confirms->account_id }}</td>
                                    <td class="fw-bold text-success">৳ {{ number_format($confirms->confirm_price, 2) }}</td>
                                    <td>{{ $confirms->message ?? '—' }}</td>
                                    
                                    @php($result = App\Models\order::where('crop_id', $confirms->crop_id)->where('c_username', $confirms->cust_username)->first())
                                    
                                    <td>
                                        @if($result === null)
                                            <a href="{{ route('delete_confirm',['id'=>$confirms->id]) }}" 
                                               onclick="return confirm('Are you sure you want to delete this payment confirmation?');"
                                               class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Locked</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

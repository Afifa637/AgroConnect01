@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <h3 class="mb-4"><i class="fas fa-bell"></i> Bid Notifications</h3>

    <div class="row">
        @foreach($notifications as $val)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5><i class="fas fa-user"></i> New Bid from <strong>{{ $val['cust_username'] }}</strong></h5>
                    <p><i class="fas fa-leaf"></i> Crop: <strong>{{ $val['crop_name'] }}</strong></p>
                    <p><i class="fas fa-hand-holding-usd"></i> Price: <span class="badge bg-success">{{ $val['bid_price'] }} Tk</span></p>
                    <p class="text-muted"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($val['created_at'])->diffForHumans() }}</p>
                    <a href="{{ route('crop_details',['id'=>$val['crop_id']]) }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-eye"></i> View Crop
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

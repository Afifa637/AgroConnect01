@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Bid Messages</h4>
        </div>
        <div class="card-body">

            @forelse($messages as $message)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-success mb-1">
                                <i class="fas fa-user me-1"></i>{{ $message->cust_username }}
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $message->created_at }}
                            </small>
                        </div>

                        <p class="mb-2">
                            <strong>Crop:</strong> {{ $message->crop_name }} <br>
                            <strong>Bid Price:</strong> {{ $message->bid_price }} <br>
                            <strong>Message:</strong> {{ $message->message }}
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            <!-- ✅ Existing working routes -->
                            <a href="{{ route('confirm_form', ['id' => $message->id]) }}" 
                               class="btn btn-success btn-sm" 
                               title="Confirm Payment">
                                <i class="fa fa-check-circle"></i>
                            </a>

                            <a target="_blank" href="{{ route('crop_details', ['id' => $message->crop_id]) }}" 
                               class="btn btn-info btn-sm" 
                               title="Crop Details">
                                <i class="fas fa-info-circle"></i>
                            </a>

                            <a target="_blank" href="{{ route('bids_download_invoice', ['id' => $message->id]) }}" 
                               class="btn btn-warning btn-sm" 
                               title="Download Invoice">
                                <i class="fas fa-cloud-download-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox me-2"></i>No messages found.
                </div>
            @endforelse

        </div>
    </div>
</div>

@endsection

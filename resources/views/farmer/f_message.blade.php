@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Messages</h4>
        </div>
        <div class="card-body">
            @forelse($messages as $message)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold text-success mb-1">
                                <i class="fas fa-user me-1"></i>{{ $message->sender }}
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $message->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <p class="mb-2">{{ $message->content }}</p>
                        <div>
                            <a href="{{ route('farmer.message.reply', $message->id) }}" 
                               class="btn btn-outline-success btn-sm" 
                               data-bs-toggle="tooltip" title="Reply">
                                <i class="fas fa-reply"></i>
                            </a>
                            <a href="{{ route('farmer.message.delete', $message->id) }}" 
                               class="btn btn-outline-danger btn-sm" 
                               data-bs-toggle="tooltip" title="Delete">
                                <i class="fas fa-trash-alt"></i>
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

@extends('admin.headerFooter')

@section('title', 'Contact Messages')

@section('body')
<div class="container-fluid py-4">
    <h2 class="mb-4 text-success"><i class="bi bi-envelope"></i> Contact Messages</h2>

    @if($messages->isEmpty())
        <div class="alert alert-info">No messages found.</div>
    @else
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Received At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr>
                    <td>{{ $msg->id }}</td>
                    <td>{{ $msg->name }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ $msg->phone }}</td>
                    <td>{{ $msg->subject }}</td>
                    <td>{{ $msg->message }}</td>
                    <td>{{ $msg->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

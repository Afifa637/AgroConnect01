@extends('admin.headerFooter')
@section('title', 'Admin Profile')
@section('body')

<div class="container-fluid py-4">
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-4 text-center mb-4">
                    <div class="card shadow-sm p-3">
                        <img src="{{ asset($user->profile_pic ?? 'uploads/default.png') }}" 
                             alt="Admin Profile Picture" 
                             class="rounded-circle mx-auto d-block" 
                             height="150" width="150">
                        <h4 class="mt-3 text-agro">{{ $user->username }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                        <p class="text-muted">Joined: {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>
                        <a href="{{ route('a_settings') }}" class="btn btn-agro mt-2">Edit Profile</a>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-sm p-4">
                        <h3 class="text-agro mb-4 text-center">Profile Details</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $user->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $user->dob }}</td>
                            </tr>
                            <tr>
                                <th>Division</th>
                                <td>{{ $user->division }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ ucfirst($user->gender) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

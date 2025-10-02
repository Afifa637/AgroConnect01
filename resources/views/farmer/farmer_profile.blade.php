@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg mb-4">
                <div class="card-body text-center">
                    <img src="{{ url($user->profile_pic ?? 'default.png') }}" class="rounded-circle mb-3" width="120" height="120">
                    <h4>{{ $user->username }}</h4>
                    <p class="text-muted">{{ $user->email }} | {{ $user->mobile }}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#info">Profile Info</a>
                        </li>
                    </ul>

                    <div class="tab-content p-3">
                        {{-- Profile Info --}}
                        <div class="tab-pane fade show active" id="info">
                            <form method="POST" action="{{route('update_farmer')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="username" value="{{ $user->username }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" name="profile_pic" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success">Update Profile</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

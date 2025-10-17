@extends('admin.headerFooter')
@section('title','User Details')
@section('body')

<div class="container my-5">
    <main>
        <div class="other-section">
            <ul class="nav nav-pills mb-3">
                <li class="nav-item"><a data-toggle="pill" class="nav-link active p-2" href="#profile">Profile Details</a></li>
                <li class="nav-item"><a data-toggle="pill" class="nav-link p-2" href="#verification">Verification</a></li>
            </ul>

            <div class="tab-content">
                <div id="profile" class="tab-pane active">
                    <h3 class="text-center text-agro">Profile Details</h3>
                    <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

                    <table class="table table-bordered mt-3">
                        <tr><th>Name</th><td>{{ $user->username }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>Mobile</th><td>{{ $user->mobile }}</td></tr>
                        <tr><th>Date of Birth</th><td>{{ $user->dob }}</td></tr>
                        <tr><th>Division</th><td>{{ $user->division }}</td></tr>
                        <tr><th>Zip Code</th><td>{{ $user->zip_code }}</td></tr>
                        <tr><th>Address</th><td>{{ $user->address }}</td></tr>
                        <tr><th>Gender</th><td>{{ $user->gender }}</td></tr>
                        <tr><th>Profile Pic</th><td><img src="{{ url($user->profile_pic) }}" height="200" width="200" alt="profile"></td></tr>
                        <tr><th>Created At</th><td>{{ $user->created_at }}</td></tr>
                    </table>
                </div>

                <div id="verification" class="tab-pane fade">
                    <h3 class="text-center text-agro">Verification Documents</h3>

                    @if(!empty($user->NID_1) && $user->NID_1 != "empty")
                        <div class="col-lg-8 mx-auto">
                            <table class="table table-bordered mt-3 text-center">
                                <tr>
                                    <th>NID Frontside</th>
                                    <td><img src="{{ url($user->NID_1) }}" alt="NID front" style="max-width:100%; height:auto;"></td>
                                </tr>
                                <tr>
                                    <th>NID Backside</th>
                                    <td><img src="{{ url($user->NID_2) }}" alt="NID back" style="max-width:100%; height:auto;"></td>
                                </tr>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">NID verification not completed.</div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

@endsection

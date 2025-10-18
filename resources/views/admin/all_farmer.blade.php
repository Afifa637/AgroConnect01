@extends('admin.headerFooter')
@section('title','All Farmers')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-12">
        <h3 class="text-success text-center mb-3"><i class="fa-solid fa-tractor"></i> Manage Farmers</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Division</th>
                        <th>Zip Code</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @php($i=1)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->division }}</td>
                            <td>{{ $user->zip_code }}</td>
                            <td>
                                @if($user->action == 'active')
                                    <span class="badge badge-success"><i class="fa-solid fa-check"></i> Active</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa-solid fa-pause"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('farmer_profile',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-info" title="Profile">
                                    <i class="fa-solid fa-user"></i>
                                </a>

                                <a href="{{ route('user_details',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-primary" title="Details">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>

                                @if($user->action == 'active')
                                    <a href="{{ route('f_action',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure you want to deactivate?');" title="Deactivate">
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </a>
                                @else
                                    <a href="{{ route('f_action',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-success"
                                       onclick="return confirm('Are you sure you want to activate?');" title="Activate">
                                        <i class="fa-solid fa-arrow-up"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
</div>
@endsection

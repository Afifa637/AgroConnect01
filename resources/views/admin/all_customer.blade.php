@extends('admin.headerFooter')
@section('title','All Buyers')
@section('body')

<div class="row">
    <div class="col-12">
        <h3 class="text-agro mb-3">Manage Buyers</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
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
                    @php($i = 1)
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
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user_profile',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-info" title="Profile"><i class="fa fa-user"></i></a>

                                <a href="{{ route('user_details',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-primary" title="Details"><i class="fas fa-info-circle"></i></a>

                                @if($user->action == 'active')
                                    <a href="{{ route('c_action',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-danger" title="Deactivate" onclick="return confirm('Are you sure you want to deactivate this user?');">
                                        <i class="fas fa-arrow-circle-down"></i>
                                    </a>
                                @else
                                    <a href="{{ route('c_action',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-success" title="Activate" onclick="return confirm('Are you sure you want to activate this user?');">
                                        <i class="fas fa-arrow-circle-up"></i>
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

@endsection

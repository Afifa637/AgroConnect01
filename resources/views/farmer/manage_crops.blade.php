@extends('farmer.headerFooter')
@section('body')

<div class="container my-5">
    <h3 class="text-center mb-4 text-success"><i class="fas fa-warehouse"></i> Manage Crops</h3>

    @if(Session::get('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Description</th>
                        <th>End Date</th>
                        <th>Image1</th>
                        <th>Image2</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @php($i=1)
                @foreach($crops as $crop)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $crop->crop_name }}</td>
                        <td>{{ $crop->crop_type }}</td>
                        <td>{{ $crop->crop_quantity }}</td>
                        <td>{{ $crop->bid_rate }} Tk</td>
                        <td>{{ Str::limit($crop->crop_description,50) }}</td>
                        <td>{{ $crop->last_date_bidding }}</td>
                        <td><img src="{{url($crop->crop_image)}}" class="img-thumbnail" width="80"></td>
                        <td><img src="{{url($crop->crop_image2)}}" class="img-thumbnail" width="80"></td>
                        <td>
                            @if($crop->status==1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('condition_crop',['id'=>$crop->id])}}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Toggle Status">
                                <i class="fas fa-toggle-on"></i>
                            </a>
                            <a href="{{route('edit_crop',['id'=>$crop->id])}}" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{route('delete_crop',['id'=>$crop->id])}}" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="float-end">
                {{ $crops }}
            </div>
        </div>
    </div>
</div>

@endsection

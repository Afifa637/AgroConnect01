@extends('admin.headerFooter')
@section('title','Manage Categories')
@section('body')

<div class="row">
    <div class="col-md-12">
        <h3 class="text-agro">Manage Categories</h3>
        <h4 class="text-center text-success">{{ Session::get('msg') }}</h4>

        <div class="table-responsive">
            <table class="table table-bordered text-center table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Admin</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @php($i = 1)
                    @foreach($categories as $categorie)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $categorie->a_username }}</td>
                            <td>{{ $categorie->categories_name }}</td>
                            <td class="text-left">{{ $categorie->categories_description }}</td>
                            <td>
                                @if($categorie->categories_status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if($categorie->categories_status == 1)
                                    <a href="{{ route('categories_status',['id'=>$categorie->id]) }}"
                                       onclick="return confirm('Are you sure you want to deactivate?');"
                                       class="btn btn-sm btn-outline-danger" title="Deactivate">
                                        <i class="fas fa-toggle-off"></i>
                                    </a>
                                @else
                                    <a href="{{ route('categories_status',['id'=>$categorie->id]) }}"
                                       onclick="return confirm('Are you sure you want to activate?');"
                                       class="btn btn-sm btn-outline-success" title="Activate">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                @endif

                                <a href="{{ route('edit_categories',['id'=>$categorie->id]) }}"
                                   class="btn btn-sm btn-agro" title="Edit" onclick="return confirm('Edit this category?');">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('categories_delete',['id'=>$categorie->id]) }}"
                                   class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

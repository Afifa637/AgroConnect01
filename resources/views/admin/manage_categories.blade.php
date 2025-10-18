@extends('admin.headerFooter')
@section('title','Manage Categories')
@section('body')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      integrity="sha512-DNf+7sE7F1A6q3FnlLRQF1gFgmqY0YkOZJ/N7T5zNjwM9nEw7K8TKuW2Z7Jbq7CYOyIh+v/4RRAJd4jFj+LqfQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.text-agro { color:#2e7d32; font-weight:600; }
.btn-agro { background:#2e7d32; color:#fff; }
.btn-agro:hover { background:#256728; color:#fff; }
table th { background:#e8f5e9; color:#1b5e20; }
</style>
@endpush

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-agro mb-3 text-center"><i class="fa-solid fa-leaf"></i> Manage Categories</h3>
      <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

      <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead>
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
              <td class="text-start">{{ $categorie->categories_description }}</td>
              <td>
                @if($categorie->categories_status == 1)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-secondary">Inactive</span>
                @endif
              </td>
              <td>
                @if($categorie->categories_status == 1)
                  <a href="{{ route('categories_status',['id'=>$categorie->id]) }}"
                     onclick="return confirm('Are you sure you want to deactivate?');"
                     class="btn btn-sm btn-outline-danger" title="Deactivate">
                     <i class="fa-solid fa-toggle-off"></i>
                  </a>
                @else
                  <a href="{{ route('categories_status',['id'=>$categorie->id]) }}"
                     onclick="return confirm('Are you sure you want to activate?');"
                     class="btn btn-sm btn-outline-success" title="Activate">
                     <i class="fa-solid fa-toggle-on"></i>
                  </a>
                @endif

                <a href="{{ route('edit_categories',['id'=>$categorie->id]) }}"
                   class="btn btn-sm btn-agro" title="Edit" onclick="return confirm('Edit this category?');">
                   <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <a href="{{ route('categories_delete',['id'=>$categorie->id]) }}"
                   class="btn btn-sm btn-outline-danger" title="Delete"
                   onclick="return confirm('Are you sure you want to delete this category?');">
                   <i class="fa-solid fa-trash"></i>
                </a>
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

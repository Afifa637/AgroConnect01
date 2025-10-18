@extends('admin.headerFooter')
@section('title','Edit Category')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white text-center">
                <h4><i class="fa-solid fa-pen-to-square"></i> Edit Category</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('update_categories_db') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $categorie->id }}">
                    <input type="hidden" name="a_username" value="{{ Session::get('a_username') }}">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Category Name</label>
                        <input type="text" name="categories_name" class="form-control" value="{{ $categorie->categories_name }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="categories_description" rows="4" class="form-control" required>{{ $categorie->categories_description }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa-solid fa-save"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

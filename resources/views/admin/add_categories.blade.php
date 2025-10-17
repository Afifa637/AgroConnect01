@extends('admin.headerFooter')
@section('title','Add Category')
@section('body')

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="jumbotron shadow-sm">
            <h3 class="text-agro text-center">Create New Category</h3>

            <form method="POST" action="{{ route('save_categories_db') }}" class="mt-3">
                @csrf
                <input type="hidden" name="a_username" value="{{ Session::get('a_username') }}">

                <div class="form-group">
                    <label class="font-weight-bold">Category Name</label>
                    <input type="text" name="categories_name" class="form-control" placeholder="E.g. Vegetables" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Description</label>
                    <textarea name="categories_description" rows="4" class="form-control" placeholder="Short description" required></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-agro btn-block" value="Save Category">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

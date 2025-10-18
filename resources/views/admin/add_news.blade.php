@extends('admin.headerFooter')
@section('title','Add News')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white text-center">
                <h4><i class="fa-solid fa-newspaper"></i> Publish Agricultural News</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('save_news_db') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="username" value="{{ Session::get('a_username') }}">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">News Title</label>
                        <input type="text" name="news_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Short Description</label>
                        <input type="text" name="news_description" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Long Description</label>
                        <textarea name="long_description" rows="6" class="form-control" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Feature Image</label>
                        <input type="file" name="news_image" class="form-control-file" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fa-solid fa-paper-plane"></i> Publish News
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

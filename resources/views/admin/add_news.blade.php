@extends('admin.headerFooter')
@section('title','Add News')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="jumbotron shadow-sm">
            <h3 class="text-agro text-center">Publish News</h3>

            <form method="POST" action="{{ route('save_news_db') }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="hidden" name="username" value="{{ Session::get('a_username') }}">

                <div class="form-group">
                    <label class="font-weight-bold">News Title</label>
                    <input type="text" name="news_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Short Description</label>
                    <input type="text" name="news_description" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Long Description</label>
                    <textarea name="long_description" rows="6" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Feature Image</label>
                    <input type="file" name="news_image" class="form-control-file" accept="image/*" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-agro btn-block" value="Publish News">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

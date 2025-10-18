@extends('admin.headerFooter')
@section('title','Edit News')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="jumbotron shadow-sm">
            <h3 class="text-agro text-center">Edit News</h3>

            <form method="POST" action="{{ route('update_news_db') }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="hidden" name="username" value="{{ Session::get('a_username') }}">
                <input type="hidden" name="id" value="{{ $news->id }}">

                <div class="form-group">
                    <label class="font-weight-bold">News Title</label>
                    <input type="text" name="news_name" class="form-control" value="{{ $news->news_name }}" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Short Description</label>
                    <input type="text" name="news_description" class="form-control" value="{{ $news->news_description }}" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Long Description</label>
                    <textarea name="long_description" rows="8" class="form-control" required>{{ $news->long_description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">News Image</label>
                    <div class="mb-2">
                        <input type="file" name="news_image" class="form-control-file" accept="image/*">
                    </div>
                    <div>
                        @if($news->news_image)
                            <img src="{{ asset($news->news_image) }}" alt="current image" width="120" height="120" style="object-fit:cover; border-radius:4px;">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-agro btn-block" value="Update News">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

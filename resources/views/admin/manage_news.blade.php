@extends('admin.headerFooter')
@section('title','Manage News')
@section('body')
<div class="container-fluid py-4">
<div class="row">
    <div class="col-12">
        <h3 class="text-agro mb-3">Manage News</h3>
        <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Long Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @php($i=1)
                    @foreach($newses as $news)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $news->username }}</td>
                            <td>{{ $news->news_name }}</td>
                            <td>{{ $news->news_description }}</td>
                            <td class="text-justify">{{ Str::limit($news->long_description, 120) }}</td>
                            <td><img src="{{ asset($news->news_image) }}" alt="{{ $news->news_name }}" width="150" height="100" style="object-fit:cover;"></td>
                            <td>
                                <a href="{{ route('edit_news',['id'=>$news->id]) }}"
                                   class="btn btn-sm btn-agro" onclick="return confirm('Edit this news?');" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('delete_news',['id'=>$news->id]) }}"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this news?');" title="Delete">
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
</div>
@endsection

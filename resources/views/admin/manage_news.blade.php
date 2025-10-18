@extends('admin.headerFooter')
@section('title','Manage News')
@section('body')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
.text-agro { color:#2e7d32; font-weight:600; }
.btn-agro { background:#2e7d32; color:#fff; }
.btn-agro:hover { background:#256728; color:#fff; }
table th { background:#e8f5e9; color:#1b5e20; }
</style>
@endpush

<div class="container-fluid py-4">
  <h3 class="text-agro mb-3 text-center"><i class="fa-solid fa-newspaper"></i> Manage News</h3>
  <h5 class="text-center text-success">{{ Session::get('msg') }}</h5>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead>
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
          <td class="text-start">{{ Str::limit($news->long_description,120) }}</td>
          <td><img src="{{ asset($news->news_image) }}" alt="{{ $news->news_name }}" width="140" height="90" class="rounded"></td>
          <td>
            <a href="{{ route('edit_news',['id'=>$news->id]) }}"
               class="btn btn-sm btn-agro" onclick="return confirm('Edit this news?');" title="Edit">
               <i class="fa-solid fa-pen-to-square"></i>
            </a>

            <a href="{{ route('delete_news',['id'=>$news->id]) }}"
               class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Are you sure you want to delete this news?');" title="Delete">
               <i class="fa-solid fa-trash"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

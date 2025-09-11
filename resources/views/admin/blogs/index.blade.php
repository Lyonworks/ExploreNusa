@extends('layouts.admin')
@section('title','Manage Blogs')
@section('content')
<h2 class="fw-bold mb-4">Manage Blogs</h2>
<a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">+ Add Blog</a>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
  <thead>
    <tr class="text-center">
      <th>Title</th>
      <th>Content</th>
      <th>Image</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($blogs as $blog)
      <tr class="text-center align-middle">
        <td>{{ $blog->title }}</td>
        <td>{{ $blog->content }}</td>
        <td>
          @if($blog->image)
            <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}" width="80" class="rounded">
          @else
            <span class="text-muted">No Image</span>
          @endif
        </td>
        <td>
          <a href="{{ route('blogs.edit',$blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
          <form action="{{ route('blogs.destroy',$blog->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this blog?')">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="4" class="text-center text-muted">No blogs found</td>
      </tr>
    @endforelse
  </tbody>
</table>
@endsection

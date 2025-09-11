@extends('layouts.admin')
@section('title','Create Blog')
@section('content')
<div class="container">
  <h2 class="fw-bold mb-4">Create Blog</h2>
  <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Title --}}
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" name="title" id="title"
             class="form-control @error('title') is-invalid @enderror"
             value="{{ old('title') }}" required>
      @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Content --}}
    <div class="mb-3">
      <label for="content" class="form-label">Content</label>
      <textarea name="content" id="content" rows="6"
                class="form-control @error('content') is-invalid @enderror"
                required>{{ old('content') }}</textarea>
      @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Image --}}
    <div class="mb-3">
      <label for="image" class="form-label">Image (optional)</label>
      <input type="file" name="image" id="image"
             class="form-control @error('image') is-invalid @enderror" accept="image/*">
      @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.blogs') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

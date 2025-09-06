@extends('layouts.admin')
@section('title','Edit Top Destination')
@section('content')
<div class="container">
  <h2 class="fw-bold mb-4">Edit Top Destination</h2>
  <form action="{{ route('top.update',$top->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="{{ $top->title }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Destination</label>
      <select name="destination_id" class="form-select">
        <option value="">-- None --</option>
        @foreach($destinations as $dest)
          <option value="{{ $dest->id }}" {{ $top->destination_id == $dest->id ? 'selected':'' }}>
            {{ $dest->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Image</label><br>
      @if($top->image)
        <img src="{{ asset('storage/'.$top->image) }}" width="120" class="mb-2"><br>
      @endif
      <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('top.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

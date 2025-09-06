@extends('layouts.app')
@section('title','Edit Facility')

@section('content')
<div class="container">
  <h2 class="fw-bold mb-4">Edit Facility</h2>
  <form action="{{ route('facilities.update',$facility->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label class="form-label">Destination</label>
      <select name="destination_id" class="form-select" required>
        @foreach($destinations as $destination)
          <option value="{{ $destination->id }}" 
            {{ $facility->destination_id == $destination->id ? 'selected' : '' }}>
            {{ $destination->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="{{ $facility->name }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4">{{ $facility->description }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('facilities.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

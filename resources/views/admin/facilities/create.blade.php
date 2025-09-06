@extends('layouts.app')
@section('title','Create Facility')

@section('content')
<div class="container">
  <h2 class="fw-bold mb-4">Create Facility</h2>
  <form action="{{ route('facilities.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Destination</label>
      <select name="destination_id" class="form-select" required>
        <option value="">-- Select Destination --</option>
        @foreach($destinations as $destination)
          <option value="{{ $destination->id }}">{{ $destination->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" placeholder="Facility name" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4" placeholder="Enter description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('facilities.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection

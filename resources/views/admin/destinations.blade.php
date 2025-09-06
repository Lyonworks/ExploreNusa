@extends('layouts.admin')
@section('title','Manage Destinations')
@section('content')

<h3 class="fw-bold mb-3">Destinations</h3>

{{-- Alert --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="m-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<a href="{{ url('/admin/destinations/create') }}" class="btn btn-theme mb-3">+ Add Destination</a>

<table class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr class="text-center">
      <th width="20%">Name</th>
      <th width="15%">Location</th>
      <th width="30%">Description</th>
      <th width="15%">Image</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($destinations as $d)
    <tr class="text-center">
      <td>{{ $d->name }}</td>
      <td>{{ $d->location }}</td>
      <td>{{ Str::limit($d->description, 80) }}</td>
      <td>
        @if($d->image)
          <img src="{{ asset('storage/'.$d->image) }}" alt="{{ $d->name }}" class="img-thumbnail" style="max-width: 120px;">
        @else
          <span class="text-muted">No image</span>
        @endif
      </td>
      <td>
        <a href="{{ url('/admin/destinations/'.$d->id.'/edit') }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ url('/admin/destinations/'.$d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this destination?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="5" class="text-center text-muted">No destinations found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection

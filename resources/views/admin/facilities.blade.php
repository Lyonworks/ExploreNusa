@extends('layouts.admin')
@section('title','Manage Facilities')
@section('content')

<h3 class="fw-bold mb-3">Facilities</h3>

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

<a href="{{ url('/admin/facilities/create') }}" class="btn btn-theme mb-3">+ Add Facility</a>

<table class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr class="text-center">
      <th width="20%">Destination</th>
      <th width="20%">Facility</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($facilities as $f)
    <tr class="text-center">
      <td>{{ $f->destination->name }}</td>
      <td>{{ $f->facility }}</td>
      <td>
        <a href="{{ url('/admin/facilities/'.$f->id.'/edit') }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ url('/admin/facilities/'.$f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this facility?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="5" class="text-center text-muted">No facilities found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection

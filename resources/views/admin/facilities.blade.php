@extends('layouts.admin')
@section('title','Manage Facilities')
@section('content')
<h3 class="fw-bold mb-3">Facilities</h3>
<a href="/admin/facilities/create" class="btn btn-theme mb-3">+ Add Facility</a>
<table class="table table-bordered">
  <tr><th>Name</th><th>Location</th><th>Action</th></tr>
  @foreach($facilities as $d)
  <tr>
    <td>{{ $d->name }}</td>
    <td>{{ $d->location }}</td>
    <td>
      <a href="/admin/facilities/{{ $d->id }}/edit" class="btn btn-sm btn-primary">Edit</a>
      <form action="/admin/facilities/{{ $d->id }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection

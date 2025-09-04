@extends('layouts.admin')
@section('title','Manage Destinations')
@section('content')
<h3 class="fw-bold mb-3">Destinations</h3>
<a href="/admin/destinations/create" class="btn btn-theme mb-3">+ Add Destination</a>
<table class="table table-bordered">
  <tr><th>Name</th><th>Location</th><th>Action</th></tr>
  @foreach($destinations as $d)
  <tr>
    <td>{{ $d->name }}</td>
    <td>{{ $d->location }}</td>
    <td>
      <a href="/admin/destinations/{{ $d->id }}/edit" class="btn btn-sm btn-primary">Edit</a>
      <form action="/admin/destinations/{{ $d->id }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection

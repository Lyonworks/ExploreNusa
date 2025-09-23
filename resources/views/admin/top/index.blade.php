@extends('layouts.admin')
@section('title','Manage Top Destinations')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold">Manage Top Destinations</h3>

  <div class="d-flex gap-2">
    <a href="{{ route('top.create') }}" class="btn btn-theme mb-3">+ Add Destination</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
  <thead>
    <tr class="text-center">
      <th>Destination</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tops as $top)
      <tr class="text-center">
        <td>{{ $top->destination->name ?? '-' }}</td>

        <td>
          <a href="{{ route('top.edit',$top->id) }}" class="btn btn-sm btn-primary">Edit</a>
          <form action="{{ route('top.destroy',$top->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection

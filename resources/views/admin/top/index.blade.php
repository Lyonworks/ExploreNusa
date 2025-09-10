@extends('layouts.admin')
@section('title','Manage Top Destinations')
@section('content')
<h2 class="fw-bold mb-4">Top Destinations</h2>
<a href="{{ route('top.create') }}" class="btn btn-primary mb-3">+ Add Destination</a>

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

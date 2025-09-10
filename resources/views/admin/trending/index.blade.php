@extends('layouts.admin')
@section('title','Manage Trending Tours')
@section('content')
<h2 class="fw-bold mb-4">Trending Tours</h2>
<a href="{{ route('trending.create') }}" class="btn btn-primary mb-3">+ Add Tour</a>

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
    @foreach($tours as $tour)
      <tr class="text-center">
        <td>{{ $tour->destination->name ?? '-' }}</td>
        
        <td>
          <a href="{{ route('trending.edit',$tour->id) }}" class="btn btn-sm btn-primary">Edit</a>
          <form action="{{ route('trending.destroy',$tour->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection

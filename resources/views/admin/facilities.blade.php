@extends('layouts.admin')
@section('title','Manage Facilities')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold">Manage Facilities</h3>

  <div class="d-flex gap-2">
    <form action="{{ route('admin.facilities') }}" method="GET" class="d-flex gap-2">
        <select name="destination_id" class="form-select form-select-sm">
            <option value="">All Destinations</option>
            @foreach($destinations as $destination)
                <option value="{{ $destination->id }}"
                    {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                    {{ $destination->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-theme btn-sm">Filter</button>
        <a href="{{ route('admin.facilities') }}" class="btn btn-theme btn-sm">Reset</a>
    </form>

    <a href="{{ url('/admin/facilities/create') }}" class="btn btn-theme">+ Add Facility</a>
  </div>
</div>

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

<div class="table-responsive">
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
                    <a href="{{ route('facilities.edit', $f->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('facilities.destroy', $f->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this facility?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No facilities found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

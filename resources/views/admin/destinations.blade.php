@extends('layouts.admin')
@section('title','Manage Destinations')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold">Manage Destinations</h3>

  <div class="d-flex gap-2">
    <form action="{{ route('admin.destinations') }}" method="GET" class="d-flex gap-2 align-items-center">
        <input type="hidden" name="location" value="{{ request('location') }}">

        <div class="dropdown">
            <button class="btn btn-theme btn-sm dropdown-toggle" type="button" id="locationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                {{ request('location') ?: 'All Locations' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="locationDropdown">
                <li>
                    <button
                        class="dropdown-item {{ request('location') ? '' : 'active' }}"
                        type="button"
                        data-value=""
                        onclick="(function(b){var f=b.closest('form'),v=b.getAttribute('data-value'); f.querySelector('input[name=location]').value=v; f.querySelector('#locationDropdown').innerText = v || 'All Locations'; f.submit();})(this)">
                        All Locations
                    </button>
                </li>
                @foreach($destinations->pluck('location')->unique() as $loc)
                    <li>
                        <button
                            class="dropdown-item {{ request('location') == $loc ? 'active' : '' }}"
                            type="button"
                            data-value="{{ $loc }}"
                            onclick="(function(b){var f=b.closest('form'),v=b.getAttribute('data-value'); f.querySelector('input[name=location]').value=v; f.querySelector('#locationDropdown').innerText = v || 'All Locations'; f.submit();})(this)">
                            {{ $loc }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('admin.destinations') }}" class="btn btn-theme btn-sm">Reset</a>
    </form>

    <a href="{{ route('destinations.create') }}" class="btn btn-theme">+ Add Destination</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
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

<div class="card shadow-sm rounded-4 p-3">
    <table class="table table-responsive align-middle mb-0">
      <thead>
        <tr class="text-center">
          <th width="15%">Name</th>
          <th width="12%">Location</th>
          <th width="25%">Description</th>
          <th width="20%">Facilities</th>
          <th width="13%">Image</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($destinations as $d)
          @if(!request('location') || request('location') == $d->location)
          <tr class="text-center">
            <td class="fw-semibold">{{ $d->name }}</td>
            <td>{{ $d->location }}</td>
            <td class="text-start">{{ Str::limit($d->description, 100) }}</td>
            <td class="text-start">
              @if(!empty($d->facilities) && count($d->facilities) > 0)
                @foreach($d->facilities as $fac)
                  <span class="badge text-white mb-1" style="background-color: #2F4F4F;">{{ $fac }}</span>
                @endforeach
              @else
                <span class="text-muted small">No facilities</span>
              @endif
            </td>
            <td>
              @if($d->image)
                <img src="{{ asset('storage/'.$d->image) }}" alt="{{ $d->name }}" class="img-thumbnail" style="max-width: 100px;">
              @else
                <span class="text-muted">No image</span>
              @endif
            </td>
            <td>
              <a href="{{ route('destinations.edit', $d->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('destinations.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this destination?');">
                @csrf 
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endif
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted">No destinations found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    
    <div class="mt-3">
        {{ $destinations->links() }}
    </div>
</div>

@endsection
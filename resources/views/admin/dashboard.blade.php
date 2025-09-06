@extends('layouts.admin')
@section('title','Admin Dashboard')

@section('content')
<div class="container-fluid">
  <h2 class="text-center fw-bold mb-4">Admin Dashboard</h2>

  <div class="row g-4">
    {{-- Card Destination --}}
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <h5 class="fw-bold mb-3">Manage Destinations</h5>
          <p class="text-muted">Create, update, delete, and view all destinations.</p>
          <a href="/admin/destinations" class="btn btn-theme">Go to Destinations</a>
        </div>
      </div>
    </div>

    {{-- Card Facility --}}
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <h5 class="fw-bold mb-3">Manage Facilities</h5>
          <p class="text-muted">Manage facilities for destinations.</p>
          <a href="/admin/facilities" class="btn btn-theme">Go to Facilities</a>
        </div>
      </div>
    </div>

    {{-- Card Trending --}}
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <h5 class="fw-bold mb-3">Manage Trending Tours</h5>
          <p class="text-muted">Manage trending tours.</p>
          <a href="/admin/trending" class="btn btn-theme">Go to Trending</a>
        </div>
      </div>
    </div>

    {{-- Card Top --}}
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <h5 class="fw-bold mb-3">Manage Top Destinations</h5>
          <p class="text-muted">Manage top-rated destinations.</p>
          <a href="/admin/top" class="btn btn-theme">Go to Top</a>
        </div>
      </div>
    </div>

    {{-- Card Reviews --}}
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <h5 class="fw-bold mb-3">Manage Reviews</h5>
          <p class="text-muted">View and moderate user reviews.</p>
          <a href="/admin/reviews" class="btn btn-theme">Go to Reviews</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

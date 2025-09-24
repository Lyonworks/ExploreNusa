@extends('layouts.app')

@section('title','Destinations')

@section('content')
  {{-- Hero --}}
  <section class="text-center my-5" data-aos="fade-down" data-aos-duration="800">
    <h1 class="fw-bold">Discover Destinations</h1>
    <p class="text-muted">Choose your dream travel experience with ExploreNusa</p>
  </section>

  {{-- List Destinations --}}
  <div class="row">
    @foreach($destinations as $dest)
    <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $loop->index * 100 }}">
      <div class="card h-100 shadow-sm">
        <img src="{{ $dest->image ? asset('storage/'.$dest->image) : 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $dest->name }}">
        <div class="card-body">
          <h5 class="card-title">{{ $dest->name }}</h5>
          <p class="text-muted small">{{ Str::limit($dest->description, 60) }}</p>
          <a href="{{ route('destinations.show', $dest->id) }}" class="btn btn-theme w-100">View Detail</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection

{{-- resources/views/home.blade.php --}}
@extends('layouts.app')
@section('title','Home')
@section('content')

{{-- Hero --}}
<div class="text-center py-5">
  <h1 class="fw-bold text-primary">Find Your Suitable Destination</h1>
  <p class="text-muted">Explore incredible things to do around</p>
  <form action="/search" method="GET" class="d-flex justify-content-center">
    <input type="text" name="keyword" class="form-control w-50 me-2" placeholder="Search destination...">
    <button class="btn btn-theme">Search</button>
  </form>
</div>

{{-- Trending Tours --}}
<h3 class="mt-5 mb-3 fw-bold">Trending Tours</h3>
<div class="row">
  @foreach($destinations as $d)
  <div class="col-md-3 mb-4">
    <div class="card h-100 shadow-sm">
      <img src="{{ $d->image }}" class="card-img-top" alt="">
      <div class="card-body">
        <h5>{{ $d->name }}</h5>
        <a href="/destinations/{{ $d->id }}" class="btn btn-theme btn-sm">View</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Testimonials --}}
<h3 class="mt-5 mb-3 fw-bold">What Travelers Say</h3>
<div class="row">
  @foreach($reviews as $r)
  <div class="col-md-4">
    <div class="p-3 bg-light rounded shadow-sm mb-3">
      ⭐ {{ $r->rating }}/5 <br>
      "{{ $r->review }}" <br>
      <small>- {{ $r->user->name ?? $r->guest_name }}</small>
    </div>
  </div>
  @endforeach
</div>
@endsection

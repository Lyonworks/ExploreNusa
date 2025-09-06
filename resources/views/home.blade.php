@extends('layouts.app')
@section('title','ExploreNusa')

@section('content')
{{-- Hero Section --}}
<section class="text-center my-5">
  <h1 class="fw-bold text-primary">Find Your Suitable Destination</h1>
  <p class="text-muted">Explore incredible things to do around</p>
  <form action="/search" method="GET" class="d-flex justify-content-center mt-4" style="max-width:500px;margin:auto;">
    <input type="text" name="keyword" class="form-control rounded-0 rounded-start" placeholder="Destination">
    <button type="submit" class="btn btn-theme rounded-0 rounded-end">Search</button>
  </form>
</section>

{{-- Trending Tours --}}
<section class="my-5">
  <h3 class="fw-bold mb-4">Trending Tours</h3>
  <div class="row g-4">
    @for($i=0;$i<4;$i++)
    <div class="col-6 col-md-3">
      <div class="card shadow-sm h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Destination">
        <div class="card-body text-center"><h6>Destination</h6></div>
      </div>
    </div>
    @endfor
  </div>
</section>

{{-- Top Destination --}}
<section class="my-5">
  <h3 class="fw-bold mb-4">Top Destination</h3>
  <div class="row g-4">
    @for($i=0;$i<3;$i++)
    <div class="col-12 col-md-4">
      <div class="card shadow-sm h-100">
        <img src="https://via.placeholder.com/400x250" class="card-img-top">
        <div class="card-body">
          <h6 class="card-title">Destination</h6>
          <p class="text-warning mb-0">★★★★☆</p>
        </div>
      </div>
    </div>
    @endfor
  </div>
</section>

{{-- Testimonial --}}
<section class="my-5">
  <h3 class="fw-bold mb-4">What Travelers Say</h3>
  <div class="card shadow-sm p-3 mb-4">
    <div class="d-flex align-items-start">
      <img src="https://via.placeholder.com/60" class="rounded-circle me-3">
      <div>
        <h6 class="fw-bold mb-1">Traveler Name</h6>
        <p class="text-warning mb-1">★★★★☆</p>
        <p class="text-muted mb-0">Amazing experience, I really enjoyed visiting this place!</p>
      </div>
    </div>
  </div>

  {{-- Review Form --}}
  <div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Leave Your Review</h5>
    <form action="/reviews" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="guest_name" class="form-control" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label class="form-label">Your Email</label>
        <input type="email" name="guest_email" class="form-control" placeholder="Enter your email">
      </div>
      <div class="mb-3">
        <label class="form-label">Rating</label>
        <select name="rating" class="form-select" required>
          <option value="">-- Choose Rating --</option>
          <option value="5">★★★★★ (5)</option>
          <option value="4">★★★★☆ (4)</option>
          <option value="3">★★★☆☆ (3)</option>
          <option value="2">★★☆☆☆ (2)</option>
          <option value="1">★☆☆☆☆ (1)</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Review</label>
        <textarea name="review" class="form-control" rows="3" placeholder="Write your experience..."></textarea>
      </div>
      <input type="hidden" name="destination_id" value="1"><!-- sementara fix id -->
      <button type="submit" class="btn btn-theme">Submit Review</button>
    </form>
  </div>
</section>
@endsection

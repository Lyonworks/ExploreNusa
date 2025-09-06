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
    @foreach($trendingTours as $tour)
    <div class="col-6 col-md-3">
      <div class="card shadow-sm h-100">
        <img src="{{ $tour->image ? asset('storage/'.$tour->image) : 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $tour->name }}">
        <div class="card-body text-center">
          <h6>{{ $tour->name }}</h6>
          <p class="text-muted">{{ Str::limit($tour->description, 50) }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

{{-- Top Destination --}}
<section class="my-5">
  <h3 class="fw-bold mb-4">Top Destination</h3>
  <div class="row g-4">
    @foreach($topDestinations as $top)
    <div class="col-12 col-md-4">
      <div class="card shadow-sm h-100">
        <img src="{{ $top->image ? asset('storage/'.$top->image) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $top->name }}">
        <div class="card-body">
          <h6 class="card-title">{{ $top->name }}</h6>
          <p class="text-muted">{{ Str::limit($top->description, 100) }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

{{-- Testimonial --}}
<section class="my-5">
  <h3 class="fw-bold mb-4">What Travelers Say</h3>

  {{-- flash / pesan sukses --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- errors --}}
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @forelse($reviews as $review)
    <div class="card shadow-sm p-3 mb-4">
      <div class="d-flex align-items-start">
        <i class="bi bi-person-circle fs-3 me-3"></i>
        <div>
          <h6 class="fw-bold mb-1">
            {{ $review->guest_name ?? $review->user->name ?? 'Anonymous' }}
            @if($review->destination)
              <small class="text-secondary">· {{ $review->destination->name }}</small>
            @endif
          </h6>

          <p class="text-warning mb-1">
            {!! str_repeat('★', $review->rating) . str_repeat('☆', 5 - $review->rating) !!}
          </p>

          <p class="text-muted mb-0">{{ $review->review }}</p>
          <small class="text-secondary">{{ $review->created_at->diffForHumans() }}</small>
        </div>
      </div>
    </div>
  @empty
    <p class="text-muted">No reviews yet. Be the first!</p>
  @endforelse

  {{-- Review Form --}}
  <div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Leave Your Review</h5>
    @if($destinations->isEmpty())
      <p class="text-muted">No destinations available. Please add destinations first.</p>
    @else
      <form action="{{ route('reviews.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">Your Name</label>
          <input type="text" name="guest_name" class="form-control" placeholder="Enter your name" value="{{ old('guest_name', optional(auth()->user())->name) }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Destination</label>
          <select name="destination_id" class="form-control" required>
            @foreach($destinations as $dest)
              <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                {{ $dest->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label d-block">Rating</label>
          <div class="rating-wrapper">
            <div class="rating" aria-label="Rating">
              @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                <label for="star{{ $i }}">★</label>
              @endfor
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Comment</label>
          <textarea name="review" class="form-control" rows="3" placeholder="Write your experience...">{{ old('review') }}</textarea>
        </div>

        <button type="submit" class="btn btn-theme">Submit Review</button>
      </form>
    @endif
  </div>
</section>
@endsection

@extends('layouts.app')
@section('title','ExploreNusa')

@section('content')
{{-- Hero Section --}}
<section class="text-center mt-5 mb-3" data-aos="fade-up" >
  <h1 class="fw-bold" data-aos="fade-down">Find Your Suitable Destination</h1>
  <p class="text-muted lead" data-aos="fade-up"  data-aos-delay="200">
    Explore incredible things to do around
  </p>
  <div class="d-flex justify-content-center mt-4"
       style="max-width:500px; margin:auto;"
       data-aos="zoom-in"
       data-aos-delay="400">
    <input type="text" id="keyword" name="keyword"
           class="form-control rounded-start"
           placeholder="Search destination...">
  </div>
</section>

{{-- Search Results --}}
<div id="searchResults"
     class="search-results card shadow-sm"
     style="max-width:666px; margin:auto; display:none;"
     data-aos="fade-up" >
</div>

{{-- Trending Tours --}}
<section class="my-5" data-aos="fade-up" >
  <h3 class="text-center fw-bold mb-4">Trending Tours</h3>
  <div class="row g-4">
    @foreach($trendingTours as $tour)
      <div class="col-6 col-md-3"
           data-aos="zoom-in"
           data-aos-delay="{{ $loop->index * 100 }}">
        <a href="{{ route('destinations.show', $tour->destination->id) }}"
           class="text-decoration-none text-dark">
          <div class="card shadow-sm h-100">
            <img src="{{ $tour->destination->image ? asset('storage/'.$tour->destination->image) : 'https://via.placeholder.com/300x200' }}"
                class="card-img-top"
                alt="{{ $tour->destination->name }}">
            <div class="card-body text-center">
                <h6>{{ $tour->destination->name }}</h6>
                <p class="text-muted">{{ Str::limit($tour->destination->description, 50) }}</p>

                @php
                    $avgRating = round($tour->destination->reviews->avg('rating'), 1); // rata-rata 1 angka desimal
                @endphp

                @if($avgRating > 0)
                    <div class="text-warning mb-2">
                    {!! str_repeat('★', floor($avgRating)) . str_repeat('☆', 5 - floor($avgRating)) !!}
                    <small>({{ $avgRating }})</small>
                    </div>
                @else
                    <small class="text-muted">No reviews yet</small>
                @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

{{-- Top Destination --}}
<section class="my-5" data-aos="fade-up" >
  <h3 class="text-center fw-bold mb-4">Top Destination</h3>
  <div class="row g-4">
    @foreach($topDestinations as $top)
      <div class="col-12 col-md-4" data-aos="fade-up"  data-aos-delay="{{ $loop->index * 150 }}">
        <a href="{{ route('destinations.show', $top->destination->id) }}"
           class="text-decoration-none text-dark">
          <div class="card shadow-sm h-100">
            <img src="{{ $top->destination->image ? asset('storage/'.$top->destination->image) : 'https://via.placeholder.com/400x250' }}"
                 class="card-img-top"
                 alt="{{ $top->destination->name }}">
            <div class="card-body">
              <h6 class="card-title">{{ $top->destination->name }}</h6>
              <p class="text-muted">{{ Str::limit($top->destination->description, 100) }}</p>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

{{-- Testimonial --}}
<section class="my-5" data-aos="fade-up" >
  <h3 class="text-center fw-bold mb-4">What Travelers Say</h3>

  {{-- flash / pesan sukses --}}
  @if(session('success'))
    <div class="alert alert-success" data-aos="fade-down">{{ session('success') }}</div>
  @endif

  {{-- errors --}}
  @if($errors->any())
    <div class="alert alert-danger" data-aos="fade-down">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div id="reviewCarousel"class="carousel slide" data-bs-ride="carousel" data-aos="fade-up"  data-aos-delay="200">
    <div class="carousel-inner">
      @forelse ($reviews->chunk(5) as $chunkIndex => $chunk)
        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
          <div class="row justify-content-center">
            @foreach ($chunk as $review)
              <div class="col-md-2"
                   data-aos="zoom-in"
                   data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card shadow-sm p-3 h-100">
                  <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle fs-3 me-2 text-dark"></i>
                    <div>
                      <h6 class="mb-0 fw-bold">
                        {{ $review->guest_name ?? $review->user->name ?? 'Anonymous' }}
                        @if($review->destination)
                          <span class="text-secondary"> · {{ $review->destination->name }}</span>
                        @endif
                      </h6>
                    </div>
                  </div>

                  <div class="review-rating text-warning">
                    {!! str_repeat('★', $review->rating) . str_repeat('☆', 5 - $review->rating) !!}
                  </div>

                  <p class="review-text">{{ $review->review }}</p>
                  <small class="text-secondary">{{ $review->created_at->diffForHumans() }}</small>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @empty
        <p class="text-muted">No reviews yet. Be the first!</p>
      @endforelse
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button"
            data-bs-target="#reviewCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon custom-arrow" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button"
            data-bs-target="#reviewCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon custom-arrow" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>

    <!-- Pagination Indicators -->
    <div class="carousel-indicators mt-3">
      @foreach ($reviews->chunk(5) as $chunkIndex => $chunk)
        <button type="button"
                data-bs-target="#reviewCarousel"
                data-bs-slide-to="{{ $chunkIndex }}"
                class="{{ $chunkIndex == 0 ? 'active' : '' }}"
                aria-current="true"
                aria-label="Slide {{ $chunkIndex + 1 }}"></button>
      @endforeach
    </div>
  </div>

  {{-- Review Form --}}
  <div class="card shadow-sm p-4 mt-4"
       data-aos="zoom-in"
       data-aos-delay="400">
    <h5 class="fw-bold mb-3">Leave Your Review</h5>
    @if($destinations->isEmpty())
      <p class="text-muted">No destinations available. Please add destinations first.</p>
    @else
      <form action="{{ route('reviews.store') }}" method="POST">
        @csrf

        <div class="mb-3" data-aos="fade-up"  data-aos-delay="100">
          <label class="form-label">Your Name</label>
          <input type="text" name="guest_name"
                 class="form-control"
                 placeholder="Enter your name"
                 value="{{ old('guest_name', optional(auth()->user())->name) }}">
        </div>

        <div class="mb-3" data-aos="fade-up"  data-aos-delay="200">
          <label class="form-label">Destination</label>
          <select name="destination_id" class="form-control" required>
            <option value="">Select Destination</option>
            @foreach($destinations as $dest)
              <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                {{ $dest->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3" data-aos="fade-up"  data-aos-delay="300">
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

        <div class="mb-3" data-aos="fade-up"  data-aos-delay="400">
          <label class="form-label">Comment</label>
          <textarea name="review"
                    class="form-control"
                    rows="3"
                    placeholder="Write your experience...">{{ old('review') }}</textarea>
        </div>

        <button type="submit" class="btn btn-theme" data-aos="fade-up"  data-aos-delay="500">
          Submit Review
        </button>
      </form>
    @endif
  </div>
</section>
@endsection

@extends('layouts.app')

@section('title', $destination->name)

@section('content')
<section class="my-5 container">
  <div class="card shadow-sm border-0 rounded-4 p-4">
    <div class="row g-4">

      {{-- Kolom kiri --}}
      <div class="col-md-5 d-flex flex-column">
        {{-- Gambar --}}
        <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://via.placeholder.com/600x400' }}"
             class="img-fluid rounded-3 mb-3 w-100"
             alt="{{ $destination->name }}">

        {{-- Reviews --}}
        <div class="flex-grow-1">
          <h6 class="fw-bold mb-3">Reviews</h6>
          <div style="max-height: 200px; overflow-y: auto;" class="pe-2">
            @forelse($reviews as $review)
              <div class="card border-0 shadow-sm mb-2">
                <div class="card-body py-2">
                  <p class="mb-1 fw-semibold">{{ $review->user->name ?? 'Anonymous' }}</p>
                  <div class="review-line">
                    <p class="text-warning mb-0">⭐ {{ $review->rating }}</p>
                    @if(trim($review->review))
                      <small class="text-muted review-text">{{ $review->review }}</small>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <p class="text-muted">No reviews yet.</p>
            @endforelse
          </div>
        </div>
      </div>

      {{-- Kolom kanan --}}
      <div class="col-md-7 position-relative pb-5">
        <h3 class="fw-bold mb-1">{{ $destination->name }}</h3>
        <p class="text-muted mb-2">
          <i class="bi bi-geo-alt-fill"></i> {{ $destination->location }}
        </p>

        <p class="mb-4">{{ $destination->description }}</p>

        {{-- Facilities --}}
        @if($destination->facilities->count())
          <h6 class="fw-bold">Facilities</h6>
          <ul class="list-unstyled mb-0">
            @foreach($destination->facilities as $facility)
              <li>• {{ $facility->facility }}</li>
            @endforeach
          </ul>
        @endif

        <a href="{{ route('destinations.index') }}"
           class="btn btn-theme position-absolute btn-back"
           aria-label="Back to Destinations">
          <i class="bi bi-arrow-left"></i> Back to Destinations
        </a>
      </div>

    </div>
  </div>
</section>

<section class="my-5 container">
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

  {{-- Review Form --}}
  <div class="card shadow-sm border-0 rounded-4 p-4">
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
          <input type="hidden" name="destination_id" value="{{ $destination->id }}">
          <select class="form-control" disabled>
            <option>{{ $destination->name }}</option>
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

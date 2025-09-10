@extends('layouts.app')

@section('title', $destination->name)

@section('content')
<section class="my-5 container">
  <div class="row">
    {{-- Gambar --}}
    <div class="col-md-6">
      <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://via.placeholder.com/600x400' }}"
           class="img-fluid rounded shadow-sm"
           alt="{{ $destination->name }}">
    </div>

    {{-- Detail --}}
    <div class="col-md-6">
      <h1 class="fw-bold text-primary">{{ $destination->name }}</h1>
      <p class="text-muted">
        <i class="bi bi-geo-alt-fill"></i> {{ $destination->location }}
      </p>

      {{-- Rating --}}
      @if($destination->reviews_avg_rating)
        <p>
          ⭐ {{ number_format($destination->reviews_avg_rating, 1) }}
          ({{ $destination->reviews_count }} reviews)
        </p>
      @endif

      <p class="mt-3">{{ $destination->description }}</p>

      {{-- Facilities --}}
      @if($destination->facilities->count())
        <h5 class="mt-4">Facilities</h5>
        <ul class="list-unstyled">
          @foreach($destination->facilities as $facility)
            <li>• {{ $facility->facility }}</li>
          @endforeach
        </ul>
      @endif

      <a href="{{ route('destinations.index') }}" class="btn btn-secondary mt-3">
        ← Back to Destinations
      </a>
    </div>
  </div>

  {{-- Reviews --}}
  <div class="mt-5">
    <h3>Reviews</h3>
    @forelse($reviews as $review)
      <div class="border-bottom py-2">
        <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
        <span class="text-warning">⭐ {{ $review->rating }}</span>
        <p class="mb-0">{{ $review->comment }}</p>
      </div>
    @empty
      <p class="text-muted">No reviews yet.</p>
    @endforelse
  </div>
</section>
@endsection

@extends('layouts.app')

@section('title',$destination->name)

@section('content')
  {{-- Breadcrumbs --}}
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="/destinations">Destinations</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $destination->name }}</li>
    </ol>
  </nav>

  {{-- Destination Title --}}
  <h2 class="fw-bold text-primary">{{ $destination->name }}</h2>
  <p class="text-muted">{{ $destination->location }}</p>

  {{-- Photos --}}
  <div class="row mb-4">
    <div class="col-md-8">
      <img src="{{ $destination->main_photo }}" class="img-fluid rounded shadow-sm" alt="">
    </div>
    <div class="col-md-4">
      <div class="row g-2">
        @foreach($destination->photos as $photo)
          <div class="col-6">
            <img src="{{ $photo }}" class="img-fluid rounded shadow-sm" alt="">
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Overview --}}
  <div class="mb-4">
    <h4 class="text-success">Overview</h4>
    <p>{{ $destination->description }}</p>
  </div>

  {{-- Facilities --}}
  <div class="mb-4">
    <h4 class="text-success">Facilities</h4>
    <ul>
      @foreach($destination->facilities as $fac)
        <li>{{ $fac }}</li>
      @endforeach
    </ul>
  </div>

  {{-- Itinerary Suggestion --}}
  <div class="mb-4">
    <h4 class="text-success">Itinerary Suggestion</h4>
    <p>{{ $destination->itinerary }}</p>
  </div>

  {{-- Reviews --}}
  <div class="mb-4">
    <h4 class="text-success">Traveler Reviews</h4>
    @foreach($destination->reviews as $review)
      <div class="border rounded p-3 mb-3 shadow-sm">
        <strong>{{ $review->user }}</strong> ⭐ {{ $review->rating }}/5
        <p class="mb-0">{{ $review->comment }}</p>
      </div>
    @endforeach
  </div>
@endsection

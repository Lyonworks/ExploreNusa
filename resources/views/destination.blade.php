@extends('layouts.app')
@section('title',$destination->name)

@section('content')
{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href="/destinations">Destinations</a></li>
    <li class="breadcrumb-item active">{{ $destination->name }}</li>
  </ol>
</nav>

{{-- Photos --}}
<div class="row mb-4">
  <div class="col-md-8">
    <img src="{{ $destination->main_photo ?? 'https://via.placeholder.com/800x400' }}" class="img-fluid rounded">
  </div>
  <div class="col-md-4">
    <div class="row g-2">
      @foreach($destination->photos ?? [] as $photo)
      <div class="col-12">
        <img src="{{ $photo }}" class="img-fluid rounded">
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Overview --}}
<h3>Overview</h3>
<p>{{ $destination->description }}</p>

{{-- Facilities --}}
<h4>Facilities</h4>
<ul>
  @foreach($destination->facilities as $f)
  <li>{{ $f->name }}</li>
  @endforeach
</ul>

{{-- Itinerary --}}
<h4>Itinerary Suggestion</h4>
<p>{{ $destination->itinerary ?? 'No itinerary provided.' }}</p>

{{-- Reviews --}}
<h4 class="mt-4">Reviews & Rating</h4>
@foreach($destination->reviews as $r)
<div class="border rounded p-3 mb-2">
  <strong>{{ $r->user->name ?? $r->guest_name }}</strong>
  <p class="text-warning mb-1">{{ str_repeat('★',$r->rating) }}{{ str_repeat('☆',5-$r->rating) }}</p>
  <p>{{ $r->review }}</p>
</div>
@endforeach
@endsection

@extends('layouts.app')
@section('title',$destination->name)
@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href="/destinations">Destination</a></li>
    <li class="breadcrumb-item active">{{ $destination->name }}</li>
  </ol>
</nav>

{{-- Photos --}}
<div class="row">
  <div class="col-md-8">
    <img src="{{ $destination->image }}" class="img-fluid rounded mb-3" alt="">
  </div>
  <div class="col-md-4">
    @foreach($destination->photos as $p)
    <img src="{{ $p }}" class="img-fluid rounded mb-2" alt="">
    @endforeach
  </div>
</div>

{{-- Overview --}}
<h3>Overview</h3>
<p>{{ $destination->description }}</p>

{{-- Facilities --}}
<h4>Facilities</h4>
<ul>
  @foreach($destination->facilities as $f)
  <li>{{ $f->name }} - {{ $f->description }}</li>
  @endforeach
</ul>

{{-- Review Section --}}
<h4 class="mt-4">Reviews & Ratings</h4>
@foreach($destination->reviews as $r)
  <div class="mb-2 border-bottom pb-2">
    ⭐ {{ $r->rating }}/5 <br>
    "{{ $r->review }}" <br>
    <small>- {{ $r->user->name ?? $r->guest_name }}</small>
  </div>
@endforeach

<form action="/reviews" method="POST" class="mt-3">
  @csrf
  <input type="hidden" name="destination_id" value="{{ $destination->id }}">
  <label>Rating</label>
  <select name="rating" class="form-control w-25 mb-2">
    <option>5</option><option>4</option><option>3</option><option>2</option><option>1</option>
  </select>
  <textarea name="review" class="form-control mb-2" placeholder="Write your review..."></textarea>
  <button class="btn btn-theme">Submit Review</button>
</form>
@endsection

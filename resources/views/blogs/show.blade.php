@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<section class="container my-5" data-aos="fade-up" data-aos-duration="1000">
  <div class="row g-5">
    {{-- Main Article --}}
    <div class="col-lg-8">
      <h1 class="fw-bold mb-4">{{ $blog->title }}</h1>
      <img src="{{ $blog->image ? asset('storage/'.$blog->image) : 'https://via.placeholder.com/800x400' }}"
           class="img-fluid rounded mb-4" alt="{{ $blog->title }}">

      <div class="text-muted mb-4 d-flex align-items-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->author ?? 'Unknown') }}&background=0D8ABC&color=fff&size=32&rounded=true"
             class="rounded-circle me-2" alt="Author">
        <span>{{ $blog->author ?? 'Unknown Author' }}</span>
      </div>

      <div class="blog-content">
        {!! $blog->content !!}
      </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">

      {{-- Recent Articles --}}
      <h4 class="fw-bold mb-4">Recent Articles</h4>
      @foreach($recentBlogs as $recent)
      <div class="d-flex mb-3 align-items-center">
        <img src="{{ $recent->image ? asset('storage/'.$recent->image) : 'https://via.placeholder.com/100x70' }}"
             class="flex-shrink-0 rounded me-3" alt="{{ $recent->title }}" style="width:90px; height:70px; object-fit:cover;">
        <div>
          <a href="{{ route('blogs.show',$recent->id) }}" class="fw-semibold text-dark d-block">
            {{ Str::limit($recent->title, 40) }}
          </a>
          <small class="text-muted d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($recent->author ?? 'Unknown') }}&background=f39c12&color=fff&size=20&rounded=true"
                 class="rounded-circle me-2" alt="Author">
            {{ $recent->author ?? 'Unknown' }}
          </small>
        </div>
      </div>
      @endforeach

      {{-- Suggested Destinations --}}
      <h4 class="fw-bold mt-5 mb-4">Suggested Destinations</h4>
      @foreach($suggestedDestinations as $dest)
      <div class="d-flex mb-3 align-items-center">
        <img src="{{ $dest->image ? asset('storage/'.$dest->image) : 'https://via.placeholder.com/100x70' }}"
             class="flex-shrink-0 rounded me-3" alt="{{ $dest->name }}" style="width:90px; height:70px; object-fit:cover;">
        <div>
          <a href="{{ route('destinations.show',$dest->id) }}" class="fw-semibold text-dark d-block">
            {{ Str::limit($dest->name, 40) }}
          </a>
          <small class="text-muted d-block">{{ Str::limit($dest->location, 30) }}</small>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
@endsection

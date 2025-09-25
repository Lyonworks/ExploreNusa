@extends('layouts.app')

@section('title','Blogs')

@section('content')
<section class="container my-5" data-aos="fade-up" data-aos-duration="1000">
  <h1 class="fw-bold text-center mb-4" data-aos="zoom-in" data-aos-duration="800">
    Our Blog
  </h1>
  <div class="row g-4">
    @forelse($blogs as $blog)
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
      <div class="card h-100 shadow-sm">
        <img src="{{ $blog->image ? asset('storage/'.$blog->image) : 'https://via.placeholder.com/400x250' }}"
             class="card-img-top" alt="{{ $blog->title }}">
        <div class="card-body">
          <h5 class="card-title">{{ $blog->title }}</h5>
          <p class="text-muted small">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
        </div>
      </div>
    </div>
    @empty
      <p class="text-muted text-center" data-aos="fade-in">No blogs available yet.</p>
    @endforelse
  </div>
</section>
@endsection

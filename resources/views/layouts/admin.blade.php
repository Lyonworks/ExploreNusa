<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Admin Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>
<body >

  <div class="d-flex">
    {{-- Sidebar --}}
    <div class="text-white p-3 min-vh-100" style="width: 240px; background: #2F4F4F;">
      <h4 class="mb-3 text-center">
        <a href="/" class="text-decoration-none text-white fw-bold">ExploreNusa</a>
      </h4>
      <hr class="border-light opacity-50 mb-4">
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="/admin/dashboard" class="nav-link text-white">☰ Dashboard</a>
        </li>
        @if(Auth::check() && Auth::user()->role_id == 1)
          <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}" class="nav-link text-white">👤 Users</a>
          </li>
        @endif
        <li class="nav-item mb-2">
          <a href="/admin/destinations" class="nav-link text-white">📍 Destinations</a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/facilities" class="nav-link text-white">🏨 Facilities</a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/trending" class="nav-link text-white">🔥 Trending Tours</a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/top" class="nav-link text-white">⭐ Top Destinations</a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/reviews" class="nav-link text-white">💬 Reviews</a>
        </li>
        <li class="nav-item mb-2">
          <a href="/admin/blogs" class="nav-link text-white">📝 Blogs</a>
        </li>
      </ul>
    </div>

    {{-- Konten utama --}}
    <main class="p-4 w-100">

      {{-- Profil User yang login --}}
      @if(Auth::check())
      <div class="d-flex justify-content-between align-items-center text-white mb-4 p-3 rounded shadow-sm" style="background: #2F4F4F;">
        <div>
          <h5 class="mb-0">👋 Hai, {{ Auth::user()->name }}</h5>
          <small>Role:
            @if(Auth::user()->role_id == 1)
              Superadmin
            @elseif(Auth::user()->role_id == 2)
              Admin
            @endif
          </small>
        </div>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-sm btn-danger">Logout</button>
        </form>
      </div>
      @endif

      {{-- Konten halaman --}}
      @yield('content')
    </main>
  </div>

</body>
</html>

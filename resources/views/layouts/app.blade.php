<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','ExploreNusa')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>
<body>
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="/">ExploreNusa</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/destinations">Destination</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/blog">Blog</a></li>
      </ul>

      {{-- Auth section --}}
      @guest
        <a href="/login" class="btn btn-theme me-2">Login</a>
        <a href="/register" class="btn btn-theme">Signup</a>
      @else
        <div class="dropdown">
          <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=00b894&color=fff&rounded=true&size=32" 
                 alt="User Avatar" class="rounded-circle me-2">
            <span>{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li class="dropdown-header">
              <strong>{{ Auth::user()->name }}</strong><br>
              <small class="text-muted">{{ Auth::user()->email }}</small>
            </li>
            <li><hr class="dropdown-divider"></li>
            @if(Auth::user()->role === 'admin')
              <li><a class="dropdown-item" href="/admin/dashboard">Admin Dashboard</a></li>
            @endif
            <li>
              <form action="/logout" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      @endguest
    </div>
  </nav>

  <main class="container py-4">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="footer text-center py-3 mt-5">
    <p>© {{ date('Y') }} ExploreNusa. All rights reserved.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

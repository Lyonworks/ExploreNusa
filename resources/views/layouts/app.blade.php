<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','ExploreNusa')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .navbar, .footer { background: linear-gradient(90deg,#0d6efd,#198754); }
    .navbar a, .footer { color:#fff !important; }
    .btn-theme { background:#0d6efd; color:white; }
    .btn-theme:hover { background:#198754; }
  </style>
</head>
<body>
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="/">ExploreNusa</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/destinations">Destination</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/blog">Blog</a></li>
      </ul>
      <a href="/login" class="btn btn-light me-2">Login</a>
      <a href="/register" class="btn btn-theme">Signup</a>
    </div>
  </nav>

  <main class="container py-4">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="footer text-center py-3 mt-5">
    <p class="mb-0 text-white">&copy; 2025 ExploreNusa | Contact: info@explorenusa.com</p>
  </footer>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title','Admin Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
</head>
<body>
  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="{{ route('admin.dashboard') }}">ExploreNusa</a>
  </nav>

  <main class="container py-4">
    @yield('content')
  </main>

  <footer class="footer text-center py-3 mt-5">
    <p>© {{ date('Y') }} ExploreNusa. All rights reserved.</p>
  </footer>
</body>
</html>

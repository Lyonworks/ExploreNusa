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
        <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/destinations">Destination</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/blogs">Blog</a></li>
        </ul>
    <div class="d-flex align-items-center justify-content-center">
        <div class="vr mx-3 bg-white" style="opacity:0.3; height:32px;"></div>
    </div>

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
            @if(in_array(Auth::user()->role_id, [1, 2]))
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
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
  <script>
        document.getElementById('keyword').addEventListener('input', function() {
            let keyword = this.value.trim();

            if(keyword.length < 2) {
                document.getElementById('searchResults').style.display = 'none';
                return;
            }

            fetch(`/search?keyword=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                let container = document.getElementById('searchResults');
                container.innerHTML = '';

                if(data.length > 0) {
                data.forEach((item, index) => {
                    container.innerHTML += `
                    <div class="p-3 search-item ${index < data.length-1 ? 'border-bottom' : ''}">
                        <h6 class="fw-bold mb-1">${item.name}, <span class="text-secondary">${item.location}</span></h6>
                        <p class="text-muted mb-0">${item.description ?? ''}</p>
                    </div>
                    `;
                });
                container.style.display = 'block';
                } else {
                container.innerHTML = `<div class="p-3 text-muted">No results found.</div>`;
                container.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>

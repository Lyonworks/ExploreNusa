<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>@yield('title','Admin Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>.sidebar{height:100vh;background:#0d6efd;color:white;}</style>
</head>
<body>
<div class="d-flex">
  <div class="sidebar p-3">
    <h4>Admin</h4>
    <a href="/admin/destinations" class="d-block text-white">Destinations</a>
    <a href="/admin/facilities" class="d-block text-white">Facilities</a>
    <a href="/admin/logout" class="d-block text-white">Logout</a>
  </div>
  <div class="flex-grow-1 p-4">@yield('content')</div>
</div>
</body>
</html>

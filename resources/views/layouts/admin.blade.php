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

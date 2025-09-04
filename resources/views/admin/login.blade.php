@extends('layouts.admin')
@section('title','Login')
@section('content')
<div class="col-md-6 offset-md-3">
  <h3 class="fw-bold mb-3">Login</h3>
  <form action="/login" method="POST">
    @csrf
    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
    <input type="password" name="password" class="form-control mb-2" placeholder="Password">
    <button class="btn btn-theme w-100">Login</button>
  </form>
</div>
@endsection

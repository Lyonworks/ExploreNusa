@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="col-md-6 offset-md-3">
  <h3 class="fw-bold mb-3">Register User</h3>
  <form action="/register" method="POST">
    @csrf
    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name">
    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
    <input type="password" name="password" class="form-control mb-2" placeholder="Password">
    <button class="btn btn-theme w-100">Register</button>
  </form>
</div>
@endsection

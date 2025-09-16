@extends('layouts.app')
@section('title','Register')
@section('content')

<div class="auth-wrapper">
  <div class="auth-card">
    <!-- LEFT FORM -->
    <div class="auth-left">
      <div class="auth-tabs">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="active">Sign up</a>
      </div>

      <h3>Register User</h3>
      <form action="/register" method="POST">
        @csrf
        <input type="text" name="name" class="form-control" placeholder="Full Name">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <input type="password" name="password" class="form-control" placeholder="Password">

        <button class="btn btn-theme w-100">Register</button>
      </form>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="auth-right"></div>
  </div>
</div>
@endsection

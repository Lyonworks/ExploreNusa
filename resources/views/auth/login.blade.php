@extends('layouts.app')
@section('title','Login')
@section('content')

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="auth-wrapper">
  <div class="auth-card">
    <!-- LEFT FORM -->
    <div class="auth-left">
      <div class="auth-tabs">
        <a href="{{ route('login') }}" class="active">Login</a>
        <a href="{{ route('register') }}">Sign up</a>
      </div>

      <h3>Login</h3>
      <form action="/login" method="POST">
        @csrf
        <input type="email" name="email" class="form-control" placeholder="Email or phone number">
        <input type="password" name="password" class="form-control" placeholder="Password">

        <button class="btn btn-theme w-100">Login</button>
      </form>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="auth-right"></div>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="auth-container">
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to your Turtle Conversation account</p>

        @if (session('success'))
            <div class="alert-message success">{{ session('success') }}</div>
        @endif

        @if ($errors->has('email'))
            <div class="alert-message error">{{ $errors->first('email') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" >
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="switch-text">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>
</div>
@endsection


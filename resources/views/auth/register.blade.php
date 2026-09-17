@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>
        <p class="subtitle">Join the Turtle Conversation Marketplace</p>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert-message success">{{ session('success') }}</div>
        @endif

        {{-- Error message box (all errors grouped together) --}}
        @if ($errors->any())
            <div class="alert-message error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 8px 0 0 18px; text-align:left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" >
            </div>

            <div class="form-group">
                <label for="role">Register As</label>
                <select name="role" >
                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" id="registerBtn">Register</button>
        </form>

        <p class="switch-text">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>

@endsection

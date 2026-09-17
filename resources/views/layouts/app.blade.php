<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turtle Conservation Marketplace</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    {{-- HEADER / NAVBAR --}}
    <header>
        <div class="logo">
            <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('images/logopenyu.png') }}" alt="Logo" class="logo-img">
            </a>
             Turtle Conservation
        </div>

        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/products') }}">Products</a>

            @auth
                {{-- BUYER VIEW --}}
                @if (Auth::user()->role === 'buyer')
                    <a href="{{ route('buyer.orders') }}">My Orders</a>
                    <a href="{{ url('/contact') }}">Contact</a>
                {{-- SELLER VIEW --}}
                @elseif (Auth::user()->role === 'seller')
                    <a href="{{ route('seller.dashboard') }}">Dashboard</a>
                    <a href="{{ route('seller.orders') }}">Orders</a>
                    <a href="{{ route('seller.payments') }}">Payments</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>

            @else
                {{-- PUBLIC VIEW --}}
                <a href="{{ url('/contact') }}">Contact</a>    
                <a href="{{ route('login') }}" class="btn-light">Login</a>
                <a href="{{ route('register') }}" class="btn-outline">Register</a>

            @endauth
        </nav>
    </header>

    {{-- ========================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================= --}}
    <main class="content">
        @yield('content')
    </main>

    {{-- ========================= --}}
    {{-- FOOTER --}}
    {{-- ========================= --}}
    <footer style="background:#014e43; color:white; text-align:center; padding:25px 0; margin-top:60px;">
        <p style="margin:0; font-size:14px;">
            © 2025 Indigenous Community Marketplace — A project by Turtle Conservation Society of Malaysia (TCS)  
            <br> Empowering Indigenous Communities | Protecting Malaysia’s Turtles
        </p>
    </footer>


</body>
</html>

@extends('layouts.app')

@section('content')

{{-- ========================= --}}
{{-- HERO SECTION --}}
{{-- ========================= --}}
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Indigenous Community Marketplace</h1>
        <p class="hero-subtitle">
            A digital platform by <strong>Turtle Conservation Society of Malaysia (TCS)</strong> 
            that empowers indigenous communities to sell their handmade crafts and eco-friendly 
            products online — supporting both <strong>wildlife conservation</strong> and 
            <strong>community livelihoods</strong>.
        </p>
        <div class="hero-buttons">
            @auth
                @if (Auth::check())
                    <h2>Welcome {{ Auth::user()->name }}!</h2>
                @endif
                @if (Auth::user()->role === 'buyer')
                    <a href="{{ route('products.index') }}" class="btn-hero">Shop Now</a>
                @elseif (Auth::user()->role === 'seller')
                    <a href="{{ route('seller.dashboard') }}" class="btn-hero">Go to Dashboard</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-hero">Join as Seller</a>
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
            @endauth
        </div>
    </div>
</section>

{{-- ========================= --}}
{{-- ABOUT SECTION --}}
{{-- ========================= --}}
<section class="about">
    <h2>About This Project</h2>
    <p>
        The <strong>Indigenous Community Marketplace</strong> is an initiative by the 
        <strong>Turtle Conservation Society of Malaysia (TCS)</strong>, aimed at linking 
        <em>indigenous artisans</em> with environmentally-conscious consumers.  
        This marketplace allows local indigenous communities — such as the <strong>Orang Asli</strong> 
        — to sell traditional handicrafts, natural products, and eco-tourism items online.
    </p>
    <p>
        Every purchase supports both the <strong>conservation of freshwater turtles in Malaysia</strong> 
        and the <strong>sustainable livelihood</strong> of indigenous families.  
        The goal is to create a circular economy where conservation and community growth coexist.
    </p>
</section>

{{-- ========================= --}}
{{-- FEATURED INDIGENOUS SELLERS --}}
{{-- ========================= --}}
<section class="sellers">
    <h2>Featured Indigenous Sellers</h2>
    <p class="section-subtitle">
        Meet our local heroes — artisans from indigenous communities across Malaysia who are 
        preserving culture while promoting eco-friendly living.
    </p>
    <div class="seller-grid">
        <div class="seller-card">
            <img src="{{ asset('images/seller1.jpg') }}" alt="Seller 1">
            <h4>Ayu — Orang Asli Craftswoman</h4>
            <p>Creates handmade rattan baskets and bamboo crafts from her village in Pahang.</p>
        </div>
        <div class="seller-card">
            <img src="{{ asset('images/seller2.jpeg') }}" alt="Seller 2">
            <h4>Balan — Indigenous Eco Farmer</h4>
            <p>Grows organic herbs and natural ingredients used for traditional health remedies.</p>
        </div>
    </div>
</section>

{{-- ========================= --}}
{{-- FEATURED PRODUCTS --}}
{{-- ========================= --}}
<section class="featured">
    <h2>Featured Products</h2>
    <div class="product-grid">
        @forelse ($products as $product)
        <a href="{{ route('products.show', $product->id) }}" class="product-card-link">
            <div class="product-card">
                <div class="image-container">
                    @if ($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/default.png') }}" alt="No Image">
                    @endif
                </div>
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p class="price">RM {{ number_format($product->price, 2) }}</p>
                    @if ($product->user)
                        <p class="seller-name">Sold by <strong>{{ $product->user->name }}</strong></p>
                    @endif
                </div>
            </div>
        </a>
        @empty
            <p class="no-products">No products available right now. Please check back soon!</p>
        @endforelse
    </div>
</section>

{{-- ========================= --}}
{{-- CTA SECTION --}}
{{-- ========================= --}}
<section class="cta">
    <h2>Be Part of the Change</h2>
    <p>
        Join us in supporting indigenous artisans and protecting Malaysia’s endangered turtles.  
        Every product you purchase tells a story of empowerment and conservation.
    </p>
    <a href="{{ route('register') }}" class="btn-light">Join as Seller</a>
</section>


@endsection

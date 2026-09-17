@extends('layouts.app')

@section('content')


{{-- PRODUCTS PAGE HEADER --}}
<section class="product-page">
    <h1 class="page-title">Our Turtle-Friendly Products</h1>
    <p class="subtitle">Every purchase supports our mission to protect Malaysia’s endangered turtles 🐢💚</p>
</section>

{{-- FILTER BAR --}}
<section class="filter-bar">
    <form method="GET" action="{{ route('products.index') }}" class="filter-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product...">

        <select name="category">
            <option value="all">All Categories</option>
            <option value="Accessories" {{ request('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
            <option value="Clothing" {{ request('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
            <option value="Merchandise" {{ request('category') == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
            <option value="Bags & Pouches" {{ request('category') == 'Bags & Pouches' ? 'selected' : '' }}>Bags & Pouches</option>
        </select>

        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" step="0.01">
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" step="0.01">

        <button type="submit" class="btn-filter">Filter</button>
    </form>
</section>


{{-- PRODUCTS GRID --}}
<section class="product-grid">
    @forelse ($products as $product)
        <a href="{{ route('products.show', $product->id) }}" class="product-card-link">
            <div class="product-card" onclick="window.location='{{ route('products.show', $product->id) }}'">
                <div class="image-container">
                    <img src="{{ asset('images/products/' . ($product->image ?? 'default-product.jpg')) }}" alt="{{ $product->name }}">
                </div>
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <p class="price">RM {{ number_format($product->price, 2) }}</p>
                    <p class="desc">{{ Str::limit($product->description, 60, '...') ?? 'No description available.' }}</p>
                    <p class="category"><strong>Category:</strong> {{ $product->category ?? 'Uncategorized' }}</p>
                    <p class="seller-name">Seller: <strong>{{ $product->user->name }}</strong></p>
                </div>
            </div>
        </a>
    @empty
        <p class="no-products">No products available at the moment. Check back soon!</p>
    @endforelse
</section>


@endsection
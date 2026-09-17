@extends('layouts.app')

@section('content')
<section class="product-detail">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>›</span>
        <a href="{{ route('products.index') }}">Products</a> <span>›</span>
        <span>{{ $product->name }}</span>
    </div>

    <div class="detail-container">

        {{-- Left: Product Image --}}
        <div class="image-box">
            @if ($product->image)
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('images/default-product.jpg') }}" alt="No Image">
            @endif
        </div>

        {{-- Right: Product Info --}}
        <div class="info-box">
            <p class="seller-name">Seller: <strong>{{ $product->user->name }}</strong></p>
            <h1 class="product-name">{{ $product->name }}</h1>
            <p class="product-category">
                <strong>Category:</strong> {{ $product->category ?? 'Uncategorized' }}
            </p>

            <p class="product-price">
                RM {{ number_format($product->price, 2) }}
            </p>

            <p class="product-desc">
                {{ $product->description ?? 'No description provided for this product.' }}
            </p>

            <hr class="divider">

            {{-- Action Buttons --}}
            <div class="product-actions">
                @if (Auth::check())
                    @if (Auth::user()->role === 'buyer')
                        <form action="{{ route('buyer.order.store', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-buy">Buy Now</button>
                        </form>
                    @elseif (Auth::user()->role === 'seller')
                        <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-edit">Edit Product</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login">Login to Buy</a>
                @endif
            </div>

            <a href="{{ route('products.index') }}" class="btn-back">← Back to Products</a>
        </div>
    </div>
</section>
@endsection

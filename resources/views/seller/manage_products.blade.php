@extends('layouts.app')

@section('content')

{{-- ========================= --}}
{{-- SELLER DASHBOARD HEADER --}}
{{-- ========================= --}}
<section class="section">
    <h1 class="page-title">Manage Your Products</h1>
    <p class="subtitle">
        Welcome back, {{ Auth::user()->name }}!  
        Here you can add, update, or remove your products.
    </p>

    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Add New Product</a>
</section>

{{-- ========================= --}}
{{-- PRODUCTS TABLE --}}
{{-- ========================= --}}
<section class="section">
    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <table class="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (RM)</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" width="70" style="border-radius:8px;">
                        @else
                            <img src="{{ asset('images/default-product.jpg') }}" alt="No Image" width="70" style="border-radius:8px;">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category ?? 'Uncategorized' }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ Str::limit($product->description, 50, '...') }}</td>
                    <td>
                        {{-- View product --}}
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-view" >View</a>

                        {{-- Edit product --}}
                        <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-edit">Edit</a>

                        {{-- Delete product --}}
                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="logout-btn" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="no-orders">No products found. Add your first one above!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>

@endsection

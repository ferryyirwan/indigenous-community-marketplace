@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

{{-- ========================= --}}
{{-- EDIT PRODUCT PAGE --}}
{{-- ========================= --}}
<section class="section">
    <h1 class="page-title">Edit Product</h1>
    <p class="subtitle">Update your product details below 🛠️</p>
</section>


    {{-- === EDIT PRODUCT FORM CARD === --}}
    <div class="edit-card">
        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price (RM)</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Accessories" {{ $product->category == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                    <option value="Clothing" {{ $product->category == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="Merchandise" {{ $product->category == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
                    <option value="Bags & Pouches" {{ $product->category == 'Bags & Pouches' ? 'selected' : '' }}>Bags & Pouches</option>
                </select>
            </div>

            <div class="form-group text-center">
                <label>Current Product Image</label><br>
                @if ($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="Current Image" class="product-image-preview">
                @else
                    <p class="no-image">No image uploaded</p>
                @endif
            </div>

            <div class="form-group">
                <label for="image">Change Product Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                <img id="preview" class="preview-hidden">
            </div>

            <button type="submit" class="btn-submit">Update Product</button>
        </form>
    </div>
</section>

<script>
    // === Preview uploaded image before submitting ===
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.classList.remove('preview-hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection

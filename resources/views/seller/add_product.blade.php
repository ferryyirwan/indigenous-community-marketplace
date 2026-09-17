@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


{{-- ========================= --}}
{{-- ADD PRODUCT PAGE --}}
{{-- ========================= --}}
<section class="section">
    <h1 class="page-title">Add New Product</h1>
    <p class="subtitle">Fill in the details below to add a new item to your turtle-friendly shop 🐢</p>
</section>

<section class="section">
    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <ul style="list-style:none;margin:0;padding:0;">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="auth-card" style="max-width:600px;margin:auto;text-align:left;">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Enter product name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Enter short description"></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price (RM)</label>
                <input type="number" step="0.01" name="price" id="price" placeholder="e.g. 25.00" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Merchandise">Merchandise</option>
                    <option value="Bags & Pouches">Bags & Pouches</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                <img id="preview" style="margin-top:10px;display:none;border-radius:10px;max-width:100%;height:auto;">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">+ Add Product</button>
        </form>
    </div>
</section>

<script>
    // Preview uploaded image before submitting
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection

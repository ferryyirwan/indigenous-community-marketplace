@extends('layouts.app')

@section('content')
<div class="payment-page">
    <h1 class="page-title">Upload Payment Receipt 🧾</h1>
    <p class="subtitle">Please upload your payment receipt to confirm your purchase.</p>

    <div class="order-info">
        <p><strong>Product:</strong> {{ $order->product->name ?? 'N/A' }}</p>
        <p><strong>Total Price:</strong> RM {{ number_format($order->total_price, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    {{-- Payment Form --}}
    <form action="{{ route('buyer.payment.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="payment-form">
        @csrf
        <label for="receipt"><strong>Upload Receipt (JPG/PNG, max 2MB):</strong></label>
        <input type="file" name="receipt" id="receipt" accept="image/*" required onchange="previewImage(event)">

        {{-- Image Preview --}}
        <div class="preview-container" id="previewContainer" style="display:none;">
            <p class="preview-title">Preview:</p>
            <img id="previewImage" src="#" alt="Receipt Preview">
        </div>

        <button type="submit" class="btn-pay">Confirm & Upload</button>
    </form>

    <a href="{{ route('buyer.orders') }}" class="btn-back">← Back to My Orders</a>
</div>

{{-- Script for image preview --}}
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            previewImage.src = reader.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection

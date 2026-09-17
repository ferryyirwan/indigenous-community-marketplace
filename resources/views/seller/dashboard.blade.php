@extends('layouts.app')

@section('content')
<section class="dashboard">
    <h1 class="page-title">Seller Dashboard</h1>
    <p class="subtitle">Welcome back, {{ Auth::user()->name }}! Here’s your current store overview 👇</p>

    {{-- === STATISTICS SECTION === --}}
    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p>{{ $totalProducts }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p>{{ $totalOrders }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Sales (RM)</h3>
            <p>{{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    {{-- === QUICK ACTIONS === --}}
    <div class="quick-actions">
        <a href="{{ route('seller.products.create') }}" class="btn">+ Add Product</a>
        <a href="{{ route('seller.orders') }}" class="btn">View Orders</a>
        <a href="{{ route('seller.payments') }}" class="btn">View Payments</a>
    </div>

    {{-- === RECENT ORDERS === --}}
    <div class="recent-orders">
        <h2>Recent Orders</h2>
        @if ($recentOrders->count() > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->product->name ?? 'Deleted Product' }}</td>
                            <td>RM {{ number_format($order->total_price, 2) }}</td>
                            <td class="status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-orders">No recent orders yet.</p>
        @endif
    </div>
</section>
@endsection

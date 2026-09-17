@extends('layouts.app')

@section('content')

{{-- ========================= --}}
{{-- MANAGE ORDERS PAGE --}}
{{-- ========================= --}}
<section class="section">
    <h1 class="page-title">Manage Orders</h1>
    <p class="subtitle">
        View and manage all orders made by buyers for your products.
    </p>
</section>

<section class="section">
    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <table class="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer</th>
                <th>Product</th>
                <th>Total Price (RM)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user->name ?? 'Unknown' }}</td>
                    <td>{{ $order->product->name ?? 'Deleted Product' }}</td>
                    <td>{{ number_format($order->total_price, 2) }}</td>

                    <td>
                        <span class="status {{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td>
                        <form action="{{ route('seller.orders.update', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="status-dropdown">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button type="submit" class="btn-update">Update</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-orders">No orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>

@endsection

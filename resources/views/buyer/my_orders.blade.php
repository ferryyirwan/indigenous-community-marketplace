@extends('layouts.app')

@section('content')
<section class="my-orders">
    <h1 class="page-title">My Orders</h1>
    <p class="subtitle">Track your purchases and payment status below.</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <table class="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price (RM)</th>
                <th>Order Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                    <td>{{ number_format($order->product->price ?? 0, 2) }}</td>
                    <td>
                        <span class="status {{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="status {{ strtolower(optional($order->payment)->status ?? 'pending') }}">
                            {{ ucfirst(optional($order->payment)->status ?? 'Pending') }}
                        </span>
                    </td>
                    <td class="actions">
                        @if (($order->status === 'pending') || ($order->status === 'paid'))
                            @if(optional($order->payment)->status !== 'paid')
                                <a href="{{ route('buyer.payment.show', $order->id) }}" class="btn btn-primary">Make Payment</a>
                            @endif
                            <form action="{{ route('buyer.order.cancel', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this order?')">❌ Cancel Order</button>
                            </form>
                        @elseif ($order->status === 'completed')
                            <span class="status completed">Completed</span>
                        @elseif ($order->status === 'cancelled')
                            <span class="status cancelled">Cancelled</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection

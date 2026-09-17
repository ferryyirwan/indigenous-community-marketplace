@extends('layouts.app')

@section('content')
<section class="payments-page">
    <h1 class="page-title">Buyer Payments</h1>
    <p class="subtitle">Review payments and confirm once verified.</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <table class="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer</th>
                <th>Product</th>
                <th>Amount (RM)</th>
                <th>Receipt</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                    <td>{{ $payment->order->product->name ?? 'Deleted Product' }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>
                        @if($payment->receipt)
                            <a href="{{ asset('images/receipts/' . $payment->receipt) }}" target="_blank" class="btn btn-receipt">View</a>
                        @else
                            No receipt
                        @endif
                    </td>
                    <td>
                        <span class="status {{ strtolower($payment->status) }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('seller.payments.update', $payment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="status-dropdown">
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="confirmed" {{ $payment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            </select>
                            <button type="submit" class="btn-update">Update</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="no-orders">No payments yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection

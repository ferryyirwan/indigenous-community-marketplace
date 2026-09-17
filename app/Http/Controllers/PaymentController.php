<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Buyer: show payment form
    public function show($orderId)
    {
        $order = Order::with('product')->findOrFail($orderId);
        return view('buyer.payment', compact('order'));
    }

    // Buyer: store payment info
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::findOrFail($orderId);

        // Upload receipt
        $fileName = time() . '.' . $request->receipt->extension();
        $request->receipt->move(public_path('images/receipts'), $fileName);

        // Update or create payment
        $payment = \App\Models\Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => Auth::id(),
                'receipt' => $fileName,
                'amount' => $order->total_price,
                'status' => 'paid',
            ]
        );

        // Update order status
        $order->update(['status' => 'paid']);

        return redirect()->route('buyer.orders')->with('success', 'Payment uploaded and confirmed successfully!');
    }

    // Seller: view all payments linked to their products
    public function indexForSeller()
    {
        $payments = Payment::whereHas('order.product', function ($query) {
            $query->where('user_id', Auth::id()); // only products owned by this seller
        })
        ->with(['order.product', 'user'])
        ->latest()
        ->get();

        return view('seller.payments', compact('payments'));
    }

    // Seller: update payment status
    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();
        
        // If payment is confirmed, update order status to completed
        if ($request->status === 'confirmed') {
            $payment->order->update(['status' => 'completed']);
        }

        return redirect()->route('seller.payments')->with('success', 'Payment status updated successfully!');
    }

}

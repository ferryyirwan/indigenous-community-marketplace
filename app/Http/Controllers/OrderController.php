<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Show all products to the buyer
    public function index()
    {
        $products = Product::latest()->get();
        return view('buyer.shop', compact('products'));
    }


    // Show one product detail
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('buyer.product_detail', compact('product'));
    }

    // Dummy buy action (creates order)
    public function store($id)
    {
        $product = Product::findOrFail($id);

        // Create new order
        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'status' => 'pending',
            'total_price' => $product->price,
        ]);

        // Redirect buyer straight to payment page
        return redirect()->route('buyer.payment.show', $order->id)
            ->with('success', 'Order created! Please confirm your payment.');
    }


    // Buyer can view their past orders
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('buyer.my_orders', compact('orders'));

    }
    // Buyer: cancel an order
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'completed') {
            $order->status = 'cancelled';
            $order->save();

            return redirect()->route('buyer.orders')->with('success', 'Order has been cancelled.');
        }

        return redirect()->route('buyer.orders')->with('error', 'Completed orders cannot be cancelled.');
    }


    // Seller: view all orders for their products
    public function indexForSeller()
    {
        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['product', 'user'])->get();

        return view('seller.manage_orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('seller.orders')->with('success', 'Order status updated!');
    }


}
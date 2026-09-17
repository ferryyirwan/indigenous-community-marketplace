<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Display all products for the seller
    public function index(Request $request)
    {
        // SELLER VIEW
        if (Auth::check() && Auth::user()->role === 'seller') {
            $products = Product::where('user_id', Auth::id())->get();
            return view('seller.manage_products', compact('products'));
        }

        // PUBLIC / BUYER VIEW (with filter)
        $query = Product::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        } elseif ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        } elseif ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        return view('public.products', compact('products'));
    }


    // Show add product form
    public function create()
    {
        return view('seller.add_product');
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imageName,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Product added successfully!');
    }

    // Edit form
    public function edit(Product $product)
    {
        return view('seller.edit_product', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'description', 'category']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully!');
    }


    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('seller.dashboard')->with('success', 'Product deleted!');
    }

    // Show product details (Public & Buyer)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        return view('product_detail', compact('product', 'user'));
    }
    
    public function dashboard()
    {
        $userId = Auth::id();

        $totalProducts = Product::where('user_id', $userId)->count();
        $totalOrders = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
        $totalSales = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('total_price');

        $recentOrders = Order::with('product')
            ->whereHas('product', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('totalProducts', 'totalOrders', 'totalSales', 'recentOrders'));
    }



}


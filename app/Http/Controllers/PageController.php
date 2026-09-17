<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PageController extends Controller
{
    // Public home page
    public function home()
    {
        $products = Product::latest()->take(4)->get(); // show top 4 featured
        return view('home', compact('products'));
    }

    // Public contact page
    public function contact()
    {
        return view('public.contact');
    }
}

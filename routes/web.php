<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', function () {
    return redirect()->route('contact')->with('success', ' Your message has been sent successfully!');
})->name('contact.send');


// Public & Buyer can view products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// =====================
// AUTHENTICATION
// =====================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check-email', function (Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
});

// Home route after login
Route::get('/home', [PageController::class, 'home'])
    ->name('home')
    ->middleware('auth');

// =====================
// BUYER ROUTES
// =====================
Route::middleware(['auth'])->prefix('buyer')->group(function () {
    Route::post('/products/{id}/order', [OrderController::class, 'store'])->name('buyer.order.store');
    Route::get('/orders', [OrderController::class, 'myOrders'])->name('buyer.orders');

    // Payment routes
    Route::get('/order/{order}/payment', [PaymentController::class, 'show'])->name('buyer.payment.show');
    Route::post('/order/{order}/payment', [PaymentController::class, 'store'])->name('buyer.payment.store');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('buyer.order.cancel');
});

// =====================
// SELLER ROUTES
// =====================
Route::middleware(['auth'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('seller.dashboard');
    Route::resource('products', ProductController::class, ['as' => 'seller'])->except(['index']);
    Route::get('/orders', [OrderController::class, 'indexForSeller'])->name('seller.orders');
    Route::put('/orders/{order}', [OrderController::class, 'updateStatus'])->name('seller.orders.update');
    Route::get('/payments', [PaymentController::class, 'indexForSeller'])->name('seller.payments');
    Route::put('/seller/payments/{id}', [PaymentController::class, 'updateStatus'])->name('seller.payments.update');


    // Use “seller.products” name to avoid clash
    Route::resource('products', ProductController::class, [
        'as' => 'seller',
    ])->except(['index']);
});

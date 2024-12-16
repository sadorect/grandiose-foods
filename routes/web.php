<?php

use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\AdminLoginRateLimiter;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\ShippingAddressController;



// Auth routes (added by Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    
    // Shipping Address Routes
    Route::get('/profile/addresses', [ShippingAddressController::class, 'index'])->name('profile.addresses.index');
    Route::post('/profile/addresses', [ShippingAddressController::class, 'store'])->name('profile.addresses.store');
    Route::get('/profile/addresses/{address}/edit', [ShippingAddressController::class, 'edit'])->name('profile.addresses.edit');
    Route::patch('/profile/addresses/{address}', [ShippingAddressController::class, 'update'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [ShippingAddressController::class, 'destroy'])->name('profile.addresses.destroy');

});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('categories', CategoryController::class);

Route::get('/categories', [PublicCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show'])->name('categories.show');

Route::middleware(AdminLoginRateLimiter::class)->group(function () {
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.access');
});



Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/{product}/quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');

    // Order Routes
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});




require __DIR__.'/auth.php';

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



// Auth routes (added by Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('categories', CategoryController::class);

Route::get('/categories', [PublicCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show'])->name('categories.show');

//Route::middleware(AdminLoginRateLimiter::class)->group(function () {
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login']);
//});



Route::post('/cart/add/{product:slug}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');




require __DIR__.'/auth.php';

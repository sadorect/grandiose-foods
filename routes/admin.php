<?php

use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryManagementController;

Route::middleware(['auth', AdminAccess::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::get('/profile/sessions', [ProfileController::class, 'sessions'])->name('profile.sessions');
    Route::delete('/profile/sessions/{session}', [ProfileController::class, 'terminateSession'])->name('profile.sessions.terminate');

    // Authentication
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Categories
    Route::resource('categories', CategoryManagementController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    Route::post('admin/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('admin/products/export', [ProductController::class, 'export'])->name('products.export');

    
    // Orders
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'destroy']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Users
    Route::resource('users', UserController::class);
});

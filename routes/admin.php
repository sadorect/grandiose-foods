<?php

use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminLoginRateLimiter;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CategoryManagementController;


Route::middleware(['auth', AdminAccess::class])
    ->prefix('admin')  // This adds the first 'admin'
    ->name('admin.')
    ->group(function () {
    Route::resource('categories', CategoryManagementController::class);
});


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
    //Route::resource('categories', CategoryManagementController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    Route::post('admin/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('admin/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('admin/products/{product}/images', [ProductController::class, 'updateImages'])
    ->name('products.images.update');
    Route::delete('admin/products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
    ->name('products.images.destroy');
    Route::post('products/mass-action', [ProductController::class, 'massAction'])->name('products.mass-action');


    
    // Orders
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'destroy']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Users
    Route::resource('users', UserController::class);


    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/rate-limit', [SettingsController::class, 'updateRateLimit'])->name('settings.rate-limit');

    // Contact Messages
    Route::resource('contact-messages', ContactMessageController::class);
    Route::post('contact-messages/{message}/reply', [ContactMessageController::class, 'reply'])
         ->name('contact-messages.reply');
});

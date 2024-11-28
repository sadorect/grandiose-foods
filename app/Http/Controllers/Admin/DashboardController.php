<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'ordersCount' => Order::count(),
            'customersCount' => User::where('is_admin', false)->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'lowStockProducts' => Product::where('stock_quantity', '<=', 20)->get()
        ]);
    }
}

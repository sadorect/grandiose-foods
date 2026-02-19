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
            'lowStockProducts' => Product::query()
                ->select('id', 'name', 'stock_quantity')
                ->where('stock_quantity', '<=', 20)
                ->orderBy('stock_quantity')
                ->limit(10)
                ->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('images')
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->where('is_active', true)
            ->paginate(12);

        $categories = Cache::remember('public.product.categories', now()->addMinutes(10), function () {
            return Category::query()->select('id', 'name')->orderBy('name')->get();
        });

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product->load('images', 'category'),
            'related_products' => Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with('images')
                ->limit(4)
                ->get()
        ]);
    }
}

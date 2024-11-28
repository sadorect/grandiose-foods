<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'sku' => 'required|unique:products',
            'base_price' => 'required|numeric|min:0',
            'measurement_type' => 'required|in:weight,volume',
            'variants' => 'required|array',
            'variants.*.size' => 'required|numeric',
            'variants.*.unit' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'specifications' => 'nullable|array'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'base_price' => 'required|numeric|min:0',
            'measurement_type' => 'required|in:weight,volume',
            'variants' => 'required|array',
            'variants.*.size' => 'required|numeric',
            'variants.*.unit' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'specifications' => 'nullable|array'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}

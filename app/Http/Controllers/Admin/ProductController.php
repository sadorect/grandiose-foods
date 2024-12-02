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
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
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
            'specifications' => 'nullable|json',
            'stock_quantity' => 'required|integer|min:0',
        ]);
        $validated['variants'] = json_encode($validated['variants']);
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->specifications) {
          $validated['specifications'] = json_decode($request->specifications, true);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('category'); // Eager load the category relationship
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
            'specifications' => 'nullable|json',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $validated['variants'] = json_encode($validated['variants']);
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

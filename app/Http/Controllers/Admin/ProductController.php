<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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


    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,csv'
            ]);

            Log::info('Starting import');
            Excel::import(new ProductsImport, $request->file('file'));
            Log::info('Import completed');
            
            return back()->with('success', 'Products imported successfully');
        } catch (\Exception $e) {
            Log::error('Import failed:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    public function export()
    {
        return Excel::download(new ProductsExport, 'grandiose-products.xlsx');
    }

    public function updateImages(Request $request, Product $product)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
    }

}
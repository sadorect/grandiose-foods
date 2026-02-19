<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Traits\ConvertToWebp;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ConvertToWebp;

    public function index(Request $request)
{
    $query = Product::query();

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('status')) {
        $query->where('is_active', $request->status);
    }

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('sku', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    $products = $query->with('category')->paginate(10);
    $categories = Cache::remember('admin.product.categories', now()->addMinutes(10), function () {
        return Category::query()->select('id', 'name')->orderBy('name')->get();
    });

    return view('admin.products.index', compact('products', 'categories'));
}


    public function create()
    {
        $categories = Cache::remember('admin.product.categories', now()->addMinutes(10), function () {
            return Category::query()->select('id', 'name')->orderBy('name')->get();
        });
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
        $categories = Cache::remember('admin.product.categories', now()->addMinutes(10), function () {
            return Category::query()->select('id', 'name')->orderBy('name')->get();
        });
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
        $product->cartItems()->delete();
        // Delete related order items first
        $product->orderItems()->delete();
        // Delete related product images
        $product->images()->delete();
        // Delete the product
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
        try {
            
            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            if ($request->hasFile('images')) {
                foreach($request->file('images') as $image) {
                    Log::info('Processing image:', ['name' => $image->getClientOriginalName()]);
                    $path = $this->convertToWebp($image, 'products');
                    $product->images()->create(['path' => $path]);
                    Log::info('Image saved to storage:', ['path' => $path]);
                }
            }

            return redirect()->back()->with('success', 'Images uploaded successfully');
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error uploading images: ' . $e->getMessage());
        }
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        try {
            abort_unless($image->product_id === $product->id, 404);

            // Delete file from storage
            Storage::disk('public')->delete($image->path);
            // Delete database record
            $image->delete();
            
            return back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting image');
        }
    }
    
    public function massAction(Request $request)
{
    $validated = $request->validate([
        'selected_products' => ['required', 'array', 'min:1'],
        'selected_products.*' => ['integer', 'exists:products,id'],
        'action' => ['required', 'in:delete,deactivate,activate'],
    ]);

    $selectedProducts = $validated['selected_products'];
    $action = $validated['action'];

    switch($action) {
        case 'delete':
            $products = Product::with('images')->whereIn('id', $selectedProducts)->get();

            foreach ($products as $product) {
                $product->cartItems()->delete();
                $product->orderItems()->delete();

                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->path);
                }

                $product->images()->delete();
                $product->delete();
            }

            return redirect()->route('admin.products.index')->with('success', 'Selected products deleted');
            
        case 'deactivate':
            Product::whereIn('id', $selectedProducts)->update(['is_active' => false]);
            return redirect()->route('admin.products.index')->with('success', 'Selected products deactivated');
            
        case 'activate':
            Product::whereIn('id', $selectedProducts)->update(['is_active' => true]);
            return redirect()->route('admin.products.index')->with('success', 'Selected products activated');
    }

    return redirect()->route('admin.products.index')->with('error', 'No action selected');
}


}

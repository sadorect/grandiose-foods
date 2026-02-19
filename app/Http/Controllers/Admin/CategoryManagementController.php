<?php
namespace App\Http\Controllers\Admin;


use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryManagementController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
        }

        Category::create($validated);
        Cache::forget('admin.product.categories');
        Cache::forget('public.product.categories');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id.'|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldImage = $category->getRawOriginal('image');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
        }

        $category->update($validated);
        Cache::forget('admin.product.categories');
        Cache::forget('public.product.categories');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
         // Delete associated image
        $imagePath = $category->getRawOriginal('image');
         if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
        $category->delete();
        Cache::forget('admin.product.categories');
        Cache::forget('public.product.categories');

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}

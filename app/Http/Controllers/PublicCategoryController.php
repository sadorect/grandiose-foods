<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * Controller for handling public category-related functionality.
 * 
 * The `index` method retrieves all categories with the number of associated products, and returns a view to display them.
 * 
 * The `show` method retrieves a specific category and its associated products, and returns a view to display them.
 */
class PublicCategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }
}

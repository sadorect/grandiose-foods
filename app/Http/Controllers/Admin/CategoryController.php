// Handles admin CRUD operations
namespace App\Http\Controllers\Admin;

class CategoryController extends Controller
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
        // Store logic
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Update logic
    }

    public function destroy(Category $category)
    {
        // Delete logic
    }
}

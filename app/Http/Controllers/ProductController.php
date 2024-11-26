<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'images'])
            ->firstOrFail();

        return view('products.show', [
            'product' => $product,
            'related_products' => $product->getRelated(),
        ])->with([
            'meta_description' => $product->meta_description,
            'og_title' => $product->name,
            'og_description' => $product->meta_description,
            'og_image' => $product->featured_image_url,
        ]);
    }
}

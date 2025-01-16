<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HeroSlide;

class HomeController extends Controller
{
    public function index()
    {
      $categories = Category::take(6)->get();

         $heroSlides = HeroSlide::where('is_active', true)
        ->orderBy('order')
        ->get();
    
    return view('welcome', compact('heroSlides', 'categories'));
    }
}

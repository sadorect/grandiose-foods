<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
      $categories = Category::take(6)->get();
        return view('welcome', compact('categories'));
    }
}

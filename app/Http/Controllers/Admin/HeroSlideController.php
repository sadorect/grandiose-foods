<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ConvertToWebp;

class HeroSlideController extends Controller
{
    use ConvertToWebp;

    public function index()
    {
        $slides = HeroSlide::orderBy('order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'image' => 'required|image|max:2048',
            'button_text' => 'required|max:255',
            'button_link' => 'required|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $imagePath = $this->convertToWebp($request->file('image'), 'hero-slides');
        
        HeroSlide::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'image_path' => $imagePath,
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'order' => $validated['order'],
            'is_active' => $validated['is_active']
        ]);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide created successfully');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
            'button_text' => 'required|max:255',
            'button_link' => 'required|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->convertToWebp($request->file('image'), 'hero-slides');
            $heroSlide->image_path = $imagePath;
        }

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $heroSlide->delete();
        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted successfully');
    }
}

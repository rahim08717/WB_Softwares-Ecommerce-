<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('product')->orderBy('order', 'asc')->get();
        return Inertia::render('Admin/Sliders/Index', [
            'sliders' => $sliders
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Sliders/Create', [
            'products' => Product::select('id', 'name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $product = Product::find($request->product_id);
        $link = route('product.show', $product->slug);

        Slider::create([
            'product_id' => $request->product_id,
            'title' => $request->title ?? $product->name,
            'subtitle' => $request->subtitle,
            'image' => null, 
            'link' => $link,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully!');
    }

    public function edit(Slider $slider)
    {
        return Inertia::render('Admin/Sliders/Edit', [
            'slider' => $slider,
            'products' => Product::select('id', 'name')->get()
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'nullable|string|max:255',
        ]);

        $product = Product::find($request->product_id);

        $slider->update([
            'product_id' => $request->product_id,
            'title' => $request->title ?? $product->name,
            'subtitle' => $request->subtitle,
            'link' => route('product.show', $product->slug),
            'order' => $request->order,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully!');
    }
}

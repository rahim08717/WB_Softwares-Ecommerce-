<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // ক্যাটাগরি মডেল লাগবে
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // ইমেজ ডিলিট বা হ্যান্ডেল করার জন্য

class ProductController extends Controller
{
    public function index()
    {
        // প্রোডাক্টের সাথে ক্যাটাগরিও লোড করছি (with category)
        $products = Product::with('category')->latest()->get();
        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        // প্রোডাক্ট তৈরির সময় ক্যাটাগরি সিলেক্ট করতে হবে, তাই ক্যাটাগরি পাঠাচ্ছি
        $categories = Category::where('is_active', true)->get();
        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ইমেজ ভ্যালিডেশন
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        // ইমেজ আপলোড লজিক
        if ($request->hasFile('image')) {
            // storage/app/public/products ফোল্ডারে সেভ হবে
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath, // ইমেজের পাথ সেভ হচ্ছে
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // ৪. এডিট পেজ দেখানোর জন্য
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::where('is_active', true)->get()
        ]);
    }

    // ৫. প্রোডাক্ট আপডেট করার জন্য (Image সহ)
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ];

        // যদি নতুন ছবি আপলোড করা হয়
        if ($request->hasFile('image')) {
            // ১. আগের ছবি থাকলে সেটা ডিলিট করো
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // ২. নতুন ছবি আপলোড করো
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // ৬. প্রোডাক্ট ডিলিট করার জন্য
    public function destroy(Product $product)
    {
        // প্রোডাক্ট ডিলিট করার আগে ছবি ডিলিট করতে হবে
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str; // Slug এর জন্য এটা লাগবে

class CategoryController extends Controller
{
    // ১. ক্যাটাগরি লিস্ট দেখানোর জন্য
    public function index()
    {
        $categories = Category::latest()->get();
        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories
        ]);
    }

    // ২. নতুন ক্যাটাগরি তৈরির পেজ দেখানোর জন্য
    public function create()
    {
        return Inertia::render('Admin/Categories/Create');
    }

    // ৩. ডাটাবেসে ক্যাটাগরি সেভ করার জন্য
    public function store(Request $request)
    {
        // ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // ডাটাবেসে সেভ করা
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // অটোমেটিক স্লাগ তৈরি হবে
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    // ৪. এডিট পেজ দেখানোর জন্য
    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category
        ]);
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->is_active ?? true, 
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    // ৬. ক্যাটাগরি ডিলিট করার জন্য
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}

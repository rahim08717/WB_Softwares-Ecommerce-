<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use App\Models\Slider;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        // with('product') ব্যবহার করতে হবে যাতে ইমেজ পাওয়া যায়
        $sliders = Slider::with('product')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // বাকি কোড আগের মতোই...
        $products = Product::with('category')->where('is_active', true)->latest()->get();

        return Inertia::render('Home', [
            'products' => $products,
            'sliders' => $sliders,
            // ...
        ]);
    }

    // ২. প্রোডাক্ট ডিটেইলস দেখানোর জন্য
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'reviews.user']) // রিভিউ এবং ইউজার লোড করা হচ্ছে
            ->firstOrFail();

        // রিলেটেড প্রোডাক্ট (একই ক্যাটাগরির)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return Inertia::render('ProductDetails', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    // ভাষা পরিবর্তন করার মেথড
    public function switchLanguage($lang)
    {
        $availableLocales = ['en', 'bn', 'hi', 'es', 'ur'];

        if (in_array($lang, $availableLocales)) {
            session()->put('locale', $lang); // সেশনে ভাষা রাখা
            session()->save(); // জোর করে সেভ করা
        }

        return back();
    }
}

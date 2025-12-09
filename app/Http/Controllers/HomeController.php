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

        $sliders = Slider::with('product')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();


        $products = Product::with('category')->where('is_active', true)->latest()->get();

        return Inertia::render('Home', [
            'products' => $products,
            'sliders' => $sliders,
            // ...
        ]);
    }

        public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'reviews.user']) 
            ->firstOrFail();


        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return Inertia::render('ProductDetails', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }


    public function switchLanguage($lang)
    {
        $availableLocales = ['en', 'bn', 'hi', 'es', 'ur'];

        if (in_array($lang, $availableLocales)) {
            session()->put('locale', $lang);
            session()->save();
        }

        return back();
    }
}

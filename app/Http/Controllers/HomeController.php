<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        // শুধুমাত্র Active প্রোডাক্টগুলো এবং তাদের ক্যাটাগরি নিয়ে আসছি
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->get();

        return Inertia::render('Home', [
            'products' => $products,
            // লগিন এবং রেজিস্টার রাউট চেক করার জন্য (Navbar এ লাগবে)
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    // ২. প্রোডাক্ট ডিটেইলস দেখানোর জন্য
    public function show($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('ProductDetails', [
            'product' => $product
        ]);
    }
}

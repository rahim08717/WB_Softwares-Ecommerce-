<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;   // Order মডেল ইম্পোর্ট করো
use App\Models\Product; // Product মডেল ইম্পোর্ট করো
use App\Models\User;    // User মডেল ইম্পোর্ট করো

class AdminController extends Controller
{
    public function index()
    {
        // ১. মোট অর্ডার সংখ্যা
        $totalOrders = Order::count();

        // ২. মোট প্রোডাক্ট সংখ্যা
        $totalProducts = Product::count();

        // ৩. মোট রেভিনিউ (আয়) - pending ছাড়া বাকি সব যোগ করছি
        // তুমি চাইলে শুধু 'completed' স্ট্যাটাস গুনতে পারো
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');

        // ৪. লেটেস্ট ৫টি অর্ডার (নিচে দেখানোর জন্য)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return Inertia::render('Admin/Dashboard', [
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders
        ]);
    }
}

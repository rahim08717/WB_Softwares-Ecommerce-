<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // DB Facade ইম্পোর্ট করা জরুরি
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // ১. বেসিক স্ট্যাটস
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');

        // ২. লেটেস্ট ৫টি অর্ডার (মাঝখানে দেখানোর জন্য)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // ৩. গ্রাফের জন্য ডাটা (Monthly Revenue - Bar Chart)
        $monthlyRevenue = Order::select(
            DB::raw('sum(total_price) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M') as month") // মাস অনুযায়ী গ্রুপ করা
        )
        ->whereYear('created_at', date('Y')) // বর্তমান বছরের ডাটা
        ->where('status', '!=', 'cancelled')
        ->groupBy('month')
        ->orderBy('created_at')
        ->pluck('total', 'month');

        // ৪. পাই চার্টের জন্য ডাটা (Order Status Distribution)
        $orderStats = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return Inertia::render('Admin/Dashboard', [
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'monthlyRevenue' => $monthlyRevenue,
            'orderStats' => $orderStats
        ]);
    }
}

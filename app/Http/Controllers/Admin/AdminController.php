<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');


        $recentOrders = Order::with('user')->latest()->take(5)->get();


        $monthlyRevenue = Order::select(
            DB::raw('sum(total_price) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M') as month")
        )
        ->whereYear('created_at', date('Y'))
        ->where('status', '!=', 'cancelled')
        ->groupBy('month')
        ->orderBy('created_at')
        ->pluck('total', 'month');


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

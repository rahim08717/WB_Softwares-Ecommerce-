<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ইউজারের অর্ডার লিস্ট
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'orders' => $orders,
            // প্রোফাইল আপডেটের স্ট্যাটাস পাঠানোর জন্য (Breeze ডিফল্ট)
            'status' => session('status'),
        ]);
    }

    // অর্ডার ক্যান্সেল করা
    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return back()->with('success', 'Order cancelled successfully.');
        }

        return back()->with('error', 'This order cannot be cancelled.');
    }

    // ইনভয়েস দেখানো
    public function invoice($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'user'])
            ->findOrFail($id);

        return Inertia::render('Invoice', [
            'order' => $order
        ]);
    }
}

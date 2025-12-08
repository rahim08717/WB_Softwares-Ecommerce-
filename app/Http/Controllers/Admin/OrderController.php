<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    // ১. সব অর্ডারের লিস্ট দেখানো
    public function index()
    {
        // লেটেস্ট অর্ডার আগে আসবে এবং সাথে ইউজার ডাটা থাকবে
        $orders = Order::with('user')->latest()->paginate(10);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }

    // ২. নির্দিষ্ট অর্ডারের ডিটেইলস দেখানো
    public function show($id)
    {
        // অর্ডার + ইউজার + আইটেম + আইটেমের প্রোডাক্ট ডাটা লোড করা হচ্ছে
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order
        ]);
    }

    // ৩. অর্ডারের স্ট্যাটাস আপডেট করা (Pending -> Completed)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid'
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}

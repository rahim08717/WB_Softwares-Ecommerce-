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

        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'orders' => $orders,

            'status' => session('status'),
        ]);
    }


    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return back()->with('success', 'Order cancelled successfully.');
        }

        return back()->with('error', 'This order cannot be cancelled.');
    }

   
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

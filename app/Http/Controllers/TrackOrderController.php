<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;

class TrackOrderController extends Controller
{

    public function index()
    {
        return Inertia::render('TrackOrder');
    }

        public function search(Request $request)
    {
        $request->validate([
            'order_id' => 'required|numeric',
            'phone' => 'required|string',
        ]);


        $order = Order::where('id', $request->order_id)
            ->where('address', 'like', '%' . $request->phone . '%')
            ->with('items.product')
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found or phone number does not match.');
        }

        
        return Inertia::render('TrackOrder', [
            'order' => $order
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;

class TrackOrderController extends Controller
{
    // ১. ট্র্যাকিং পেজ দেখানো
    public function index()
    {
        return Inertia::render('TrackOrder');
    }

    // ২. অর্ডার খোঁজা
    public function search(Request $request)
    {
        $request->validate([
            'order_id' => 'required|numeric',
            'phone' => 'required|string', // ভেরিফিকেশনের জন্য ফোন নম্বরও লাগবে
        ]);

        // অর্ডার খোঁজা হচ্ছে (ID এবং Phone মিলতে হবে)
        // আমরা address কলামে ফোন নম্বর রেখেছিলাম, তাই like কুয়েরি ব্যবহার করছি
        $order = Order::where('id', $request->order_id)
            ->where('address', 'like', '%' . $request->phone . '%')
            ->with('items.product')
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found or phone number does not match.');
        }

        // অর্ডার পাওয়া গেলে সেইম পেজেই ডাটা ফেরত পাঠাবো
        return Inertia::render('TrackOrder', [
            'order' => $order
        ]);
    }
}

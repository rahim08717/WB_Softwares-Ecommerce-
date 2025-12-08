<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    // ১. চেকআউট পেজ দেখানো
    public function index()
    {
        // কার্ট এম্পটি থাকলে চেকআউটে ঢুকতে দিবে না
        $cart = session()->get('cart', []);
        if (count($cart) <= 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // কার্টের প্রোডাক্ট ডিটেইলস এবং টোটাল প্রাইস হিসাব করা
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        return Inertia::render('Checkout', [
            'total' => $total,
            'cart' => $cart
        ]);
    }

    // ২. অর্ডার কনফার্ম করা (Database এ সেভ করা)
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string'
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) <= 0) {
            return redirect()->route('cart.index');
        }

        // টোটাল প্রাইস আবার ক্যালকুলেট করা (সিকিউরিটির জন্য)
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }

        // ডাটাবেস ট্রানজ্যাকশন শুরু (যাতে অর্ধেক সেভ হয়ে এরর না দেয়)
        DB::beginTransaction();

        try {
            // ১. অর্ডার টেবিল এ ডাটা সেভ
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'payment_status' => 'pending', // পেমেন্ট গেটওয়ে থাকলে এখানে 'paid' হতো
                'address' => $request->address . ' | Phone: ' . $request->phone,
            ]);

            // ২. অর্ডার আইটেম টেবিল এ ডাটা সেভ
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id],
                    'unit_price' => $product->price,
                ]);

                // ৩. স্টক কমানো (অপশনাল)
                $product->decrement('stock', $cart[$product->id]);
            }

            // ৪. সেশন থেকে কার্ট মুছে ফেলা
            session()->forget('cart');

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }
}

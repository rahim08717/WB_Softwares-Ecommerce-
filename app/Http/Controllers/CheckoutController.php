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
  
    public function index()
    {

        $cart = session()->get('cart', []);
        if (count($cart) <= 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }


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


        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }


        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'address' => $request->address . ' | Phone: ' . $request->phone,
            ]);


            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id],
                    'unit_price' => $product->price,
                ]);


                $product->decrement('stock', $cart[$product->id]);
            }


            session()->forget('cart');

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }
}

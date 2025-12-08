<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class CartController extends Controller
{
    // ১. কার্ট পেজ দেখানো
    public function index()
    {
        // সেশন থেকে কার্ট ডাটা বের করা
        $cart = session()->get('cart', []);

        // কার্টে থাকা প্রোডাক্টগুলোর ডিটেইলস ডাটাবেস থেকে আনা
        // আমরা array_keys($cart) দিয়ে শুধু প্রোডাক্টের ID গুলো নিচ্ছি
        $products = Product::whereIn('id', array_keys($cart))->get();

        // প্রোডাক্টের সাথে কোয়ান্টিটি যুক্ত করে দিচ্ছি
        $cartItems = $products->map(function ($product) use ($cart) {
            $product->quantity = $cart[$product->id];
            $product->total_price = $product->price * $cart[$product->id];
            return $product;
        });


        $total = $cartItems->sum('total_price');

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    // ২. কার্টে যোগ করা (Add to Cart)
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        // যদি প্রোডাক্ট আগে থেকেই থাকে, তাহলে সংখ্যা বাড়াও
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            // না থাকলে নতুন করে যোগ করো
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // ৩. কার্ট থেকে রিমুভ করা
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }


    // ৪. কার্ট আপডেট করা (সংখ্যা বাড়ানো/কমানো)
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        // যদি কার্টে এই প্রোডাক্ট থাকে
        if(isset($cart[$id])) {
            $quantity = $request->input('quantity');

            // সংখ্যা যদি ০ এর বেশি হয়, তবে আপডেট করো
            if ($quantity > 0) {
                $cart[$id] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Cart updated successfully!');
            }
            // সংখ্যা ০ বা তার কম হলে রিমুভ করে দাও (অপশনাল)
            else {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Item removed from cart!');
            }
        }

        return redirect()->back();
    }
}

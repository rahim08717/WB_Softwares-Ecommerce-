<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class CartController extends Controller
{
        public function index()
    {

        $cart = session()->get('cart', []);


        $products = Product::whereIn('id', array_keys($cart))->get();


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


    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);


        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {

            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }



    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);


        if(isset($cart[$id])) {
            $quantity = $request->input('quantity');


            if ($quantity > 0) {
                $cart[$id] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Cart updated successfully!');
            }

            else {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Item removed from cart!');
            }
        }

        return redirect()->back();
    }
}

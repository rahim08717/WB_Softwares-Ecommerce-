<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return Inertia::render('Wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }


    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $user = Auth::user();
        $productId = $request->product_id;


        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            $exists->delete();
            return back()->with('success', 'Removed from wishlist.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]); 
            return back()->with('success', 'Added to wishlist.');
        }
    }
}

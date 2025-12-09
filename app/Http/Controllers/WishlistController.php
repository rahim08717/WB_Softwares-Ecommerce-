<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{
    // ১. উইশলিস্ট পেজ দেখানো
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product') // প্রোডাক্টের তথ্যসহ
            ->latest()
            ->get();

        return Inertia::render('Wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    // ২. অ্যাড বা রিমুভ করা (Toggle)
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $user = Auth::user();
        $productId = $request->product_id;

        // চেক করছি আগে থেকেই আছে কিনা
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            $exists->delete(); // থাকলে ডিলিট
            return back()->with('success', 'Removed from wishlist.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]); // না থাকলে অ্যাড
            return back()->with('success', 'Added to wishlist.');
        }
    }
}

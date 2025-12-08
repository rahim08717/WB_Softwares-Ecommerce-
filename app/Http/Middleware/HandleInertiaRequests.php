<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Category;
use App\Models\Setting;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // কার্টে মোট কত পিস প্রোডাক্ট আছে তা হিসাব করা
        $cart = session()->get('cart', []);
        $totalQuantity = array_sum($cart);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            // এই লাইনটি নতুন যোগ করো
            'cartCount' => $totalQuantity,
            'categories' => Category::where('is_active', true)->get(),
            // [NEW] Settings ডাটা Key-Value আকারে পাঠানো হচ্ছে
            'settings' => Setting::all()->pluck('value', 'key'),

            // ফ্ল্যাশ মেসেজ (সাকসেস মেসেজ দেখানোর জন্য)
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],
        ];
    }
}

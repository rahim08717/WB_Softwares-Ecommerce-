<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Wishlist;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        $locale = app()->getLocale();
        $translations = [];
        $langPath = base_path("lang/{$locale}.json");

        if (file_exists($langPath)) {
            $translations = json_decode(file_get_contents($langPath), true);
        }

        // ইউজারের পারমিশন এবং রোল লোড করা
        $user = $request->user();
        $permissions = [];
        $roles = [];

        if ($user) {
            $permissions = $user->getAllPermissions()->pluck('name');
            $roles = $user->getRoleNames();
        }

        return [
            ...parent::share($request),

            'locale' => $locale,
            'translations' => $translations,

            'auth' => [
                'user' => $user,
                'permissions' => $permissions, // [IMPORTANT] পারমিশন পাঠানো হলো
                'roles' => $roles,
            ],

            'cartCount' => array_sum(session()->get('cart', [])),
            'wishlistCount' => $user ? Wishlist::where('user_id', $user->id)->count() : 0,
            'categories' => Category::where('is_active', true)->get(),
            'settings' => Setting::all()->pluck('value', 'key'),

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}

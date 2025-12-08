<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // ১. সেটিংস পেজ দেখানো
    public function index()
    {
        // ডাটাবেস থেকে সব সেটিং এনে Key-Value পেয়ারে সাজানো
        // যাতে ফ্রন্টএন্ডে settings.site_name এভাবে ধরা যায়
        $settings = Setting::all()->pluck('value', 'key');

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings
        ]);
    }

    // ২. সেটিংস আপডেট করা
    public function update(Request $request)
    {
        $input = $request->except('logo'); // লোগো আলাদা হ্যান্ডেল করব

        // টেক্সট ডাটা আপডেট
        foreach ($input as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // লোগো আপলোড লজিক
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('settings', 'public');

            // আগের লোগো ডিলিট করা (অপশনাল, ভালো প্র্যাকটিস)
            $oldLogo = Setting::where('key', 'logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            Setting::updateOrCreate(['key' => 'logo'], ['value' => $path]);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}

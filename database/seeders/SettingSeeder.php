<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'WB Shop'],
            ['key' => 'site_email', 'value' => 'mywbsoft@gmail.com'],
            ['key' => 'site_phone', 'value' => '01602024545'],
            ['key' => 'site_address', 'value' => 'Dhaka, Bangladesh'],
            ['key' => 'scrolling_text', 'value' => '🎉 Welcome to WB Shop! Get 50% OFF on your first order.'],
            ['key' => 'logo', 'value' => null], // লোগো পরে আপলোড করব
            ['key' => 'facebook', 'value' => 'https://facebook.com'],
            ['key' => 'youtube', 'value' => 'https://youtube.com'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

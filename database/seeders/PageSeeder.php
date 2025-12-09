<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'About Us',
            'Delivery Info',
            'Privacy Policy',
            'Terms & Conditions',
            'Returns & Refunds',
            'Contact Us' // কন্টাক্ট পেজের কন্টেন্ট এর জন্য
        ];

        foreach ($pages as $title) {
            Page::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "This is the default content for $title page. You can edit this from Admin Panel.",
                'is_active' => true,
            ]);
        }
    }
}

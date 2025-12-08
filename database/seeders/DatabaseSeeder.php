<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // শুধুমাত্র আমাদের তৈরি করা RolePermissionSeeder টি কল করা হলো
        $this->call(RolePermissionSeeder::class);
        $this->call(SettingSeeder::class); // <--- এই লাইনটি যোগ করো
    }
}

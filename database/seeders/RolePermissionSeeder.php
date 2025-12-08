<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ১. আগের ক্যাশ ক্লিয়ার করা (Spatie এর জন্য জরুরি)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ২. রোল তৈরি করা
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // ৩. পারমিশন তৈরি করা (কিছু স্যাম্পল পারমিশন)
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'manage users']);

        // ৪. অ্যাডমিনকে সব পারমিশন দেওয়া
        $adminRole->givePermissionTo(Permission::all());

        // ৫. স্পেশাল অ্যাডমিন ইউজার তৈরি (অ্যাসাইনমেন্ট অনুযায়ী)
        $adminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'mywbsoft@gmail.com', // এই ইমেইলটি অ্যাসাইনমেন্টে দেওয়া ছিল
            'password' => Hash::make('password'), // লগিন পাসওয়ার্ড: password
        ]);

        // অ্যাডমিন রোল অ্যাসাইন করা
        $adminUser->assignRole($adminRole);

        // ৬. টেস্টিংয়ের জন্য একজন সাধারণ ইউজার তৈরি
        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // ইউজার রোল অ্যাসাইন করা
        $normalUser->assignRole($userRole);
    }
}

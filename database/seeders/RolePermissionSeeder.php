<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            'dashboard.view',

            // User Management
            'user.view', 'user.create', 'user.edit', 'user.delete', 'user.role',

            // Role Management
            'role.view', 'role.create', 'role.edit', 'role.delete',

            // Category Management
            'category.view', 'category.create', 'category.edit', 'category.delete',

            // Product Management
            'product.view', 'product.create', 'product.edit', 'product.delete',

            // Order Management
            'order.view', 'order.edit', 'order.delete', 'order.invoice',

            // Slider Management
            'slider.view', 'slider.create', 'slider.edit', 'slider.delete',

            // Page Management
            'page.view', 'page.create', 'page.edit', 'page.delete',

            // Contact Messages
            'contact.view', 'contact.reply', 'contact.delete',

            // Settings
            'setting.view', 'setting.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $superAdminRole->givePermissionTo(Permission::all());

        $managerRole->givePermissionTo([
            'dashboard.view',
            'product.view', 'product.create', 'product.edit',
            'order.view', 'order.edit',
            'category.view', 'category.create',
            'slider.view', 'contact.view'
        ]);

        // Super Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'mywbsoft@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->syncRoles([$superAdminRole]);

        // Normal User
        $normalUser = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $normalUser->syncRoles([$userRole]);
    }
}

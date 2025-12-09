<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class RoleController extends Controller
{
    // ১. রোলের লিস্ট দেখানো
    public function index()
    {
        // রোল এবং তার পারমিশনসহ লোড করা হচ্ছে
        $roles = Role::with('permissions')->latest()->get();
        return Inertia::render('Admin/Roles/Index', ['roles' => $roles]);
    }

    // ২. রোল তৈরির পেজ (সব পারমিশন পাঠাতে হবে চেকবক্সের জন্য)
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Admin/Roles/Create', ['permissions' => $permissions]);
    }

    // ৩. নতুন রোল সেভ করা
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);

        // চেকবক্স থেকে আসা পারমিশনগুলো অ্যাসাইন করা
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    // ৪. রোল এডিট পেজ
    public function edit(Role $role)
    {
        // ১. এডমিন রোল এডিট করা যাবে না (নিরাপত্তার জন্য)
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Cannot edit Super Admin role.');
        }

        // ২. সব পারমিশন এবং রোলের বর্তমান পারমিশন লোড করা
        $permissions = Permission::all();
        $role->load('permissions');

        return Inertia::render('Admin/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);

        // পারমিশন সিঙ্ক করা (আগের গুলো মুছে নতুন গুলো সেট হবে)
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }

    // ৬. রোল ডিলিট করা
    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return back()->with('error', 'Cannot delete Admin role!');
        }
        $role->delete();
        return back()->with('success', 'Role deleted successfully');
    }
}

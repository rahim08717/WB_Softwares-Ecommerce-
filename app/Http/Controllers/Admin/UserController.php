<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Spatie Role মডেল
use Inertia\Inertia;

class UserController extends Controller
{
    // ১. ইউজার লিস্ট দেখানো
    public function index()
    {
        // সব ইউজার এবং তাদের বর্তমান রোল লোড করা হচ্ছে
        $users = User::with('roles')->latest()->paginate(10);

        // সব এভেইলেবল রোল (Admin, User) পাঠানো হচ্ছে ড্রপডাউনের জন্য
        $roles = Role::pluck('name');

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    // ২. রোল আপডেট করা
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($id);

        // নিজের রোল নিজে চেঞ্জ করা যাবে না (সিকিউরিটি)
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role!');
        }

        // Spatie এর syncRoles মেথড দিয়ে রোল আপডেট করা হয়
        $user->syncRoles($request->role);

        return back()->with('success', 'User role updated successfully!');
    }

    // ৩. ইউজার ডিলিট করা (অপশনাল)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}

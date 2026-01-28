<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(10)
        ]);
    }

    public function toggle(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', 'User status updated');
    }

    public function toggleAdmin(User $user)
    {
        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        return back()->with('success', 'User role updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted');
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::when(request('search'), function ($q, $s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%");
            })
            ->when(request('role'), fn($q, $r) => $q->where('role', $r))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Only Super Admin can create users.');
        }
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Only Super Admin can create users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::defaults()],
            'role' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        ActivityLog::log('created', "Created user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isSuperAdmin() && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized. You can only edit your own profile.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isSuperAdmin() && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized. You can only edit your own profile.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        if (auth()->user()->isSuperAdmin()) {
            $rules['role'] = 'required|string';
            $rules['is_active'] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }

        $user->update($validated);
        ActivityLog::log('updated', "Updated user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Only Super Admin can delete users.');
        }
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete your own account.');
        }
        ActivityLog::log('deleted', "Deleted user: {$user->name}");
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}

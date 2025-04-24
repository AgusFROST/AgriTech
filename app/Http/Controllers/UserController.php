<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $users = User::with('role')
        ->filter(['search' => $search])
        ->orderBy('name')
        ->paginate(10)
        ->appends(['search' => $search]);

    return view('dashboard.users.index', compact('users', 'search'));
}


    public function create()
    {
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6',
        ]);

        User::create([
            'uid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users-management.index')->with('success', 'User created successfully.');
    }

    public function edit(User $users_management)
    {
        $roles = Role::all();
        return view('dashboard.users.edit', [
            'user' => $users_management,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $users_management)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $users_management->uid . ',uid',
            'role_id' => 'required|exists:roles,id',
        ]);

        $users_management->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users-management.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $users_management)
    {
        $users_management->delete();
        return redirect()->route('users-management.index')->with('success', 'User deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('client.settings-page.settings-page', compact('users'));
    }

    public function store(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'role' => 'nullable',
            'company' => 'nullable',
            'branch' => 'nullable',
            'password' => 'required|string|min:8|confirmed', // confirm must match
        ]);

        // ✅ Create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            // 'company'  => Auth::user()->company ?? null,
            // 'branch'   => Auth::user()->branch ?? null,
            'role' => strtolower($validated['role']),
            'company' => strtolower($validated['company']),
            'branch' => strtolower($validated['branch']),
        ]);

        // ✅ Redirect with success message
        return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('client.settings-page.settings-edit-page', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // ✅ Find the user
        $user = User::findOrFail($id);

        // ✅ Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'role' => 'nullable',
            'company' => 'nullable',
            'branch' => 'nullable',
        ]);

        // ✅ Update the user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $user->email,
            'phone' => $validated['phone'] ?? $user->phone,
            'address' => $validated['address'] ?? $user->address,
            'role' => isset($validated['role']) ? strtolower($validated['role']) : $user->role,
            'company' => isset($validated['company']) ? strtolower($validated['company']) : $user->company,
            'branch' => isset($validated['branch']) ? strtolower($validated['branch']) : $user->branch,
        ]);

        // ✅ Redirect with success message
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function status($id)
    {
        // ✅ Find user
        $user = User::findOrFail($id);

        // ✅ Toggle status
        $user->status = $user->status === 1 ? 0 : 1;
        $user->save();

        // ✅ Redirect back with message
        return redirect()->back()->with('success', 'User status updated successfully!');
    }

    public function destroy($id)
    {
        // ✅ Find the user
        $user = User::findOrFail($id);

        // ✅ Delete the user
        $user->delete();

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}

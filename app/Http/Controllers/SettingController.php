<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('client.settings-page.settings-page');
    }

    public function store(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // confirm must match
            'company'  => 'required|string',
            'branch'   => 'required|string',
        ]);

        // ✅ Create the user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company'  => $validated['company'],
            'branch'   => $validated['branch'],
        ]);

        // ✅ Redirect with success message
        return redirect()->back()->with('success', 'User registered successfully!');
    }
}

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
        $company = Auth::user()->company;
        $branch = Auth::user()->branch;

        $users = User::where('company', '=', $company)->where('branch', '=', $branch)->orderBy('id', 'desc')->paginate(10);


        return view('client.settings-page.settings-page', compact('users'));
    }

    public function store(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'nullable',
            'address'  => 'nullable',
            'password' => 'required|string|min:8|confirmed', // confirm must match
        ]);

        // ✅ Create the user
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'address'  => $validated['address'],
            'password' => Hash::make($validated['password']),
            'company'  => Auth::user()->company ?? null,
            'branch'   => Auth::user()->branch ?? null,
        ]);

        // ✅ Redirect with success message
        return redirect()->back()->with('success', 'User registered successfully!');
    }
}

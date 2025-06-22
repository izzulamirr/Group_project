<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the input
        $request->validate([
            'nickname' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_no' => 'nullable|string|max:15',
            'city' => 'nullable|string|max:255',
        ]);

        // Update user fields
        $user->nickname = $request->nickname ?? $user->nickname;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no ?? $user->phone_no;
        $user->city = $request->city ?? $user->city;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar); // Delete old avatar
            }
            $user->avatar = $request->file('avatar')->store('avatars');
        }

        // Handle password change
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Delete user record
        $user->delete();

        // Logout the user
        Auth::logout();

        return redirect()->route('thome')->with('success', 'Account deleted successfully.');
    }
}
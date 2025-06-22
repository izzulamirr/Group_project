<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginWithEmail(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Attempt to authenticate the user
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            $user = Auth::user(); // Get the authenticated user

            // Check if the user has role '1'
            if ($user->roles == '1' || $user->roles == 1) {
                // Redirect users with role '1' to the transaction page
                return redirect()->route('transaction.index');
            } else {
                // Redirect other users to a default dashboard page
                return redirect()->route('thome');
            }
        }

        // Return back with an error message if authentication fails
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registerWithEmail(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Corrected 'minimum' to 'min'
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => '0', // Default role, you can adjust this as needed
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        // Regenerate session ID to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect the user to a specific page after registration
        return redirect()->route('dashhome');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}

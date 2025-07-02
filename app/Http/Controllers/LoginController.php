<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function showLoginForm(Request $request)
{
    $locked = false;
 

    // Check all possible rate limiter keys for this IP
    $ip = $request->ip();
    $attempted = false;

    // Optionally, you can scan for all possible keys if you want to lock by IP only
    // Or, if you want to lock only after an email is entered, keep as is

    // If you want to lock by IP only (no email needed):
    $key = 'login-attempts:|' . $ip;
    if (RateLimiter::tooManyAttempts($key, 3)) {
        $locked = true;
    }

    return view('auth.login', compact('locked'));
}

public function login(Request $request)
{
    $email = $request->input('email');
    $ip = $request->ip();
    $key = 'login-attempts:|' . $ip;

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return back()->withErrors([
            'email' => "Too many login attempts. Please try again in 60 seconds."
        ])->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        RateLimiter::clear($key);
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->roles == '1' || $user->roles == 1) {
            return redirect()->route('transaction.index');
        } else {
            return redirect()->route('Orgdashboard');
        }
    } else {
        RateLimiter::hit($key, 60); // 1 minute lockout
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
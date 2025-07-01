<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $key = 'login-attempts:' . Str::lower($request->input('email')) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return back()->withErrors([
            'email' => "Too many login attempts. Please try again in $seconds seconds."
        ]);
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        RateLimiter::clear($key); // Clear attempts on success
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->roles == '1' || $user->roles == 1) {
            return redirect()->route('transaction.index');
        } else {
            return redirect()->route('Orgdashboard');
        }
    } else {
        RateLimiter::hit($key, 120); // 120 seconds lockout
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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
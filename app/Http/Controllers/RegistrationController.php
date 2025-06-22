<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        // Validation is automatically handled by RegistrationRequest

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect or return response
        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
}
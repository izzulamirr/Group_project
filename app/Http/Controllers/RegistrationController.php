<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        UserRole::create([
            'UserID' => $user->id,
            'RoleName' => 'user',
            'Description' => 'Normal user',
        ]);

        Auth::login($user);

        return redirect()->route('Orgdashboard')->with('success', 'Registration successful!');
    }
}
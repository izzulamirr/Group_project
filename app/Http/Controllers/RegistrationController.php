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
        // Validation is automatically handled by RegistrationRequest

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign default role (RoleID = 2, RoleName = 'user')
       UserRole::create([
        'UserID' => $user->id,
        'RoleName' => 'user',
        'Description' => 'Normal user',
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to dashboard or home
        return redirect()->route('Orgdashboard')->with('success', 'Registration successful!');
    }
}
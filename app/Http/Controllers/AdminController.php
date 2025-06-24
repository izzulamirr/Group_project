<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\Transaction;
use App\Models\Donator;
use App\Models\UserRole;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with(['organizations.transactions'])->get();
        return view('admin.dashboard', compact('users'));
    }

    public function userOrganizations($userId)
    {
        $user = User::with('organizations')->findOrFail($userId);
        return view('admin.user_organizations', compact('user'));
    }

    public function createUser()
    {
        return view('admin.CreateUser');
    }


    // Store a new user
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

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

        return redirect()->route('admin.dashboard')->with('flash_message', 'User created successfully!');
    }

    // Delete a user
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        
        return redirect()->route('admin.dashboard')->with('flash_message', 'User deleted successfully!');
    }

    public function editPermissions($userId)
    {
        $user = User::findOrFail($userId);
        $roles = UserRole::all();
        $permissions = RolePermission::pluck('Description')->unique();
        $userRole = UserRole::where('UserID', $userId)->first();
        $userPermissions = $userRole
            ? RolePermission::where('RoleID', $userRole->RoleID)->pluck('Description')->toArray()
            : [];
        return view('admin.edit_permissions', compact('user', 'roles', 'permissions', 'userRole', 'userPermissions'));
    }

    public function updatePermissions(Request $request, $userId)
    {
        $userRole = UserRole::where('UserID', $userId)->first();
        if ($userRole) {
            // Remove old permissions for this role
            RolePermission::where('RoleID', $userRole->RoleID)->delete();
            // Add new permissions
            if ($request->has('permissions')) {
                foreach ($request->permissions as $perm) {
                    RolePermission::create([
                        'RoleID' => $userRole->RoleID,
                        'Description' => $perm,
                    ]);
                }
            }
        }
        return redirect()->route('admin.dashboard')->with('flash_message', 'Permissions updated!');
    }
}
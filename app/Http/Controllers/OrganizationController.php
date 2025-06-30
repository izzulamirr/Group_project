<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\UserRole;
use App\Models\RolePermission;

class OrganizationController extends Controller
{
    // List all organizations (for donation listing)
    public function index()
    {
        $organizations = Organization::where('user_id', auth()->id())->get();
        return view('organization.mylist', compact('organizations'));
    }

    public function transactions($id)
    {
        $organization = Organization::findOrFail($id);
        $transactions = $organization->transactions;
        $total = $transactions->sum('amount');
        return view('Organization.transactions', compact('organization', 'transactions', 'total'));
    }

    // List only organizations owned by the logged-in user
    public function myOrganizations()
    {
        $organizations = Organization::where('user_id', auth()->id())->get();
        return view('organizations.my', compact('organizations'));
    }

    // Show form to create a new organization
    public function create()
    {
        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Create Organization')
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        return view('organization.create');
    }

    // Store a new organization
    public function store(Request $request)
    {
        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Create Organization')
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Organization::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'remarks' => $request->remarks,
        ]);
        return redirect()->route('organizations.my')->with('flash_message', 'Organization Added!');
    }

    // Show a single organization
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        return view('organizations.view', compact('organization'));
    }

    // Show form to edit an organization
    public function edit($id)
    {
        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Update Organization')
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $organization = Organization::findOrFail($id);
        return view('organization.edit', compact('organization'));
    }

    // Update an organization
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Update Organization')
            ->exists();

        // Only allow if user is owner or has permission
        if ($organization->user_id !== $user->id && !$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);
        $organization->update([
            'name' => $request->name,
            'remarks' => $request->remarks,
        ]);
        return redirect()->route('organizations.my')->with('flash_message', 'Organization Updated!');
    }

    // Delete an organization
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Delete Organization')
            ->exists();

        // Only allow if user is owner or has permission
        if ($organization->user_id !== $user->id && !$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $organization->delete();
        return redirect()->route('organizations.my')->with('delete_message', 'Organization Deleted!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

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
    $transactions = $organization->transactions; // assuming you have a hasMany relation
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
        return view('organization.create');
    }

    // Store a new organization
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other fields as needed
        ]);
        Organization::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'remarks' => $request->remarks, // Uncomment if you have a remarks field
            // Add other fields as needed
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
        $organization = Organization::findOrFail($id);
        // Optionally, check if the user owns this organization
        if ($organization->user_id !== auth()->id()) {
            abort(403);
        }
        return view('organization.edit', compact('organization'));
    }

    // Update an organization
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        if ($organization->user_id !== auth()->id()) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            // Add other fields as needed
        ]);
        $organization->update([
            'name' => $request->name,
            'remarks' => $request->remarks,
            // Add other fields as needed
        ]);
        return redirect()->route('organizations.my')->with('flash_message', 'Organization Updated!');
    }

    // Delete an organization
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        if ($organization->user_id !== auth()->id()) {
            abort(403);
        }
        $organization->delete();
        return redirect()->route('organizations.my')->with('delete_message', 'Organization Deleted!');
    }
}
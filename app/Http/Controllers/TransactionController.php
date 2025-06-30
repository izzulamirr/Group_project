<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Transaction;
use App\Models\Donator;
use App\Models\UserRole;
use App\Models\RolePermission;

class TransactionController extends Controller
{
    // Show all transactions for a specific organization
    public function index($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
         // Check if the authenticated user owns the organization
    if ($organization->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }
        $transactions = $organization->transactions()->with('donator')->get();
        $total = $transactions->sum('amount');
        return view('Organization.transactions', compact('organization', 'transactions', 'total'));
    }

    // Show create form for a transaction under a specific organization
    public function create($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $donators = Donator::all();

        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Create Transaction')
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }
        return view('transactions.create', compact('organization', 'donators'));
    }

    public function edit($organizationId, $transactionId)
{
    $organization = Organization::findOrFail($organizationId);

    // Check if the authenticated user owns the organization
    if ($organization->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $transaction = Transaction::findOrFail($transactionId);

    // Ensure the transaction belongs to the organization
    if ($transaction->organization_id != $organization->id) {
        abort(404, 'Transaction not found in this organization.');
    }

    $user = auth()->user();
    $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
    $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
        ->where('Description', 'Update Transaction')
        ->exists();

    if (!$hasPermission) {
        abort(403, 'Unauthorized action.');
    }

    $donators = Donator::all();
    return view('transactions.edit', compact('organization', 'transaction', 'donators'));
}

public function update(Request $request, $organizationId, $transactionId)
{
    $organization = Organization::findOrFail($organizationId);

    // Check if the authenticated user owns the organization
    if ($organization->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $transaction = Transaction::findOrFail($transactionId);

    // Ensure the transaction belongs to the organization
    if ($transaction->organization_id != $organization->id) {
        abort(404, 'Transaction not found in this organization.');
    }

    $user = auth()->user();
    $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
    $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
        ->where('Description', 'Update Transaction')
        ->exists();

    if (!$hasPermission) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'Name1' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'remarks' => 'nullable|string|max:255',
        'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($request->hasFile('receipt')) {
        $path = $request->file('receipt')->store('receipts', 'public');
        $transaction->receipt = $path;
    }

    // Update donator's Name1
    if ($transaction->donator) {
        $transaction->donator->Name1 = $request->Name1;
        $transaction->donator->save();
    }
    $transaction->amount = $request->amount;
    $transaction->remarks = $request->remarks;
    $transaction->save();

    return redirect()->route('organizations.transactions', $organizationId)
        ->with('success', 'Transaction updated successfully.');
}
    public function destroy($organization_id, Transaction $transaction)
    {
        $organization = Organization::findOrFail($organization_id);

        // Ensure the transaction belongs to the organization
        if ($transaction->organization_id != $organization->id) {
            abort(404, 'Transaction not found in this organization.');
        }

        $user = auth()->user();
        $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
        $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
            ->where('Description', 'Delete Transaction')
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();
        return redirect()->route('organizations.transactions', $organization_id)
            ->with('flash_message', 'Transaction deleted!');
    }
}
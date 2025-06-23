<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Transaction;
use App\Models\Donator;

class TransactionController extends Controller
{
    // Show all transactions for a specific organization
    public function index($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $transactions = $organization->transactions()->with('donator')->get();
        $total = $transactions->sum('amount');
        return view('Organization.transactions', compact('organization', 'transactions', 'total'));
    }

    // Show create form for a transaction under a specific organization
    public function create($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $donators = Donator::all();
        return view('transactions.create', compact('organization', 'donators'));
    }

    // Store a new transaction for a specific organization
    public function store(Request $request, $organization_id)
{
    $organization = Organization::findOrFail($organization_id);

    $request->validate([
        'donator_name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.01',
        'remarks' => 'nullable|string',
    ]);

    // Create new donator
    $donator = Donator::create([
        'Name1' => $request->donator_name,
        // add other fields if needed
    ]);

    // Create transaction
    Transaction::create([
        'organization_id' => $organization->id,
        'donator_id' => $donator->id,
        'amount' => $request->amount,
        'remarks' => $request->remarks,
    ]);

    return redirect()->route('organizations.transactions', $organization->id)
        ->with('flash_message', 'Transaction added!');
}

    // Update a transaction
    public function update(Request $request, $organization_id, Transaction $transaction)
    {
        $request->validate([
            'donator_id' => 'required|exists:donators,id',
            'amount' => 'required|numeric|min:0.01',
            'remarks' => 'nullable|string',
        ]);
        $transaction->update([
            'donator_id' => $request->donator_id,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
        ]);
        return redirect()->route('organizations.transactions', $organization_id)
            ->with('flash_message', 'Transaction updated!');
    }

    // Delete a transaction
    public function destroy($organization_id, Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('organizations.transactions', $organization_id)
            ->with('flash_message', 'Transaction deleted!');
    }
}
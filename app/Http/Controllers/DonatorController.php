<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Donator;
use App\Models\Transaction;

class DonatorController extends Controller
{
    // Show the donation form
    public function donateForm()
    {
        $organizations = Organization::all();
        return view('transactions.donate', compact('organizations'));
    }

    // Handle the donation submission
    public function donate(Request $request)
    {
        $request->validate([
            'donator_name' => 'required|string|max:255',
            'donations' => 'required|array',
            'donations.*.recipient_id' => 'required|exists:organizations,id',
            'donations.*.amount' => 'required|numeric|min:0.01',
            'donations.*.remarks' => 'nullable|string',
        ]);

        // Calculate total amount donated
        $totalAmount = array_sum(array_column($request->donations, 'amount'));

        // Create the donator ONCE per submission
        $donator = Donator::create([
            'Name1' => $request->donator_name, // or 'Name1' if that's your column
            'amount' => $totalAmount,
        ]);

        // Create a transaction for each donation row
        foreach ($request->donations as $donation) {
            Transaction::create([
                'organization_id' => $donation['recipient_id'],
                'amount' => $donation['amount'],
                'remarks' => $donation['remarks'] ?? null,
                'donator_id' => $donator->id,
            ]);
        }

    return redirect()->route('transaction.thank');
    }
}
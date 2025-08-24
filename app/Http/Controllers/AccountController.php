<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with(['accountable'])->paginate(10);
        return view('pos.accounts.index', compact('accounts'));
    }

    public function create()
    {
        $customers = Customer::all();
        $suppliers = Supplier::all();
        return view('pos.accounts.create', compact('customers', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:customer,supplier,expense,income,asset,liability',
            'accountable_type' => 'nullable|in:App\Models\Customer,App\Models\Supplier',
            'accountable_id' => 'nullable|integer|required_if:accountable_type,App\Models\Customer,App\Models\Supplier',
            'opening_balance' => 'nullable|numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        // Generate unique account number
        $validated['account_number'] = 'ACC-' . strtoupper(Str::random(8));
        $validated['current_balance'] = $validated['opening_balance'] ?? 0;
        $validated['created_by'] = auth()->id();

        $account = Account::create($validated);
        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $transactions = $account->transactions()->latest()->paginate(10);
        return view('pos.accounts.show', compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        $customers = Customer::all();
        $suppliers = Supplier::all();
        return view('pos.accounts.edit', compact('account', 'customers', 'suppliers'));
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:customer,supplier,expense,income,asset,liability',
            'accountable_type' => 'nullable|in:App\Models\Customer,App\Models\Supplier',
            'accountable_id' => 'nullable|integer|required_if:accountable_type,App\Models\Customer,App\Models\Supplier',
            'opening_balance' => 'nullable|numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        // Update current balance based on opening balance change
        $balanceDifference = ($validated['opening_balance'] ?? 0) - $account->opening_balance;
        $validated['current_balance'] = $account->current_balance + $balanceDifference;

        $account->update($validated);
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        if ($account->transactions()->count() > 0) {
            return redirect()->route('accounts.index')->with('error', 'Cannot delete account with existing transactions.');
        }

        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}

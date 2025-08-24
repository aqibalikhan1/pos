<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountTransaction::with(['account', 'relatedAccount'])->latest();

        // Apply filters if present
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('reference_type')) {
            $query->where('reference_type', $request->reference_type);
        }

        if ($request->filled('supplier_id')) {
            $query->where('related_account_id', $request->supplier_id);
        }

        if ($request->filled('start_date')) {
            $query->where('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->paginate(10);
        $suppliers = Supplier::all(); // Fetch suppliers

        return view('pos.accounts.transactions.index', compact('transactions', 'suppliers'));
    }

    public function create()
    {
        $accounts = Account::all();
        $customers = Customer::all();
        $suppliers = Supplier::all();
        return view('pos.accounts.transactions.create', compact('accounts', 'customers', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'required|string|max:255|unique:account_transactions',
            'account_id' => 'required|integer',
            'related_account_id' => 'nullable|integer',
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0',
            'balance_after' => 'required|numeric|min:0',
            'reference_type' => 'nullable|string|max:255',
            'reference_id' => 'nullable|integer',
            'payment_method' => 'nullable|string|max:255',
            'cheque_number' => 'nullable|string|max:255',
            'cheque_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'created_by' => 'required|integer',
        ]);

        $account = Account::find($validated['account_id']);
        $currentBalance = $account->current_balance;

        // Calculate the new balance based on transaction type
        $newBalance = $validated['transaction_type'] === 'debit' 
            ? $currentBalance - $validated['amount'] 
            : $currentBalance + $validated['amount'];

        $validated['balance_after'] = $newBalance;

        $transaction = AccountTransaction::create($validated);
        // Update the account's current balance
        $account->current_balance = $newBalance;
        $account->save();
        return redirect()->route('accounts.transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show(AccountTransaction $transaction)
    {
        return view('pos.accounts.transactions.show', compact('transaction'));
    }

    public function edit(AccountTransaction $transaction)
    {
        $accounts = Account::all();
        $customers = Customer::all();
        $suppliers = Supplier::all();
        return view('pos.accounts.transactions.edit', compact('transaction', 'accounts', 'customers', 'suppliers'));
    }

    public function update(Request $request, AccountTransaction $transaction)
    {
        $validated = $request->validate([
            'transaction_number' => 'required|string|max:255|unique:account_transactions,transaction_number,' . $transaction->id,
            'account_id' => 'required|integer',
            'related_account_id' => 'nullable|integer',
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0',
            'balance_after' => 'required|numeric|min:0',
            'reference_type' => 'nullable|string|max:255',
            'reference_id' => 'nullable|integer',
            'payment_method' => 'nullable|string|max:255',
            'cheque_number' => 'nullable|string|max:255',
            'cheque_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'created_by' => 'required|integer',
        ]);

        $transaction->update($validated);
        return redirect()->route('accounts.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(AccountTransaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('accounts.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}

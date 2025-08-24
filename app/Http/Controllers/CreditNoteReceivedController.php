<?php

namespace App\Http\Controllers;

use App\Models\CreditNoteReceived;
use App\Models\Supplier;
use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreditNoteReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creditNotes = CreditNoteReceived::with(['supplier', 'account', 'creator'])
            ->latest()
            ->paginate(25);

        return view('pos.accounts.credit-notes.index', compact('creditNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::active()->get();
        $accounts = Account::supplier()->active()->get();

        return view('pos.accounts.credit-notes.create', compact('suppliers', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'credit_note_number' => 'required|string|unique:credit_notes_received',
            'supplier_id' => 'required|exists:suppliers,id',
            'account_id' => 'required|exists:accounts,id',
            'credit_note_date' => 'required|date',
            'original_purchase_date' => 'nullable|date',
            'original_invoice_number' => 'nullable|string|max:50',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['created_by'] = Auth::id();

        DB::transaction(function () use ($validated) {
            $creditNote = CreditNoteReceived::create($validated);

            // Create account transaction if approved
            if ($creditNote->status === 'approved') {
                AccountTransaction::create([
                    'account_id' => $creditNote->account_id,
                    'transaction_type' => 'credit',
                    'amount' => $creditNote->total_amount,
                    'description' => "Credit Note: {$creditNote->credit_note_number}",
                    'transaction_date' => $creditNote->credit_note_date,
                    'reference_number' => $creditNote->credit_note_number,
                    'created_by' => $creditNote->created_by,
                ]);

                // Update account balance
                $account = $creditNote->account;
                $account->current_balance -= $creditNote->total_amount;
                $account->save();
            }
        });

        return redirect()->route('credit-notes.index')
            ->with('success', 'Credit note received created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditNoteReceived $creditNote)
    {
        return view('pos.accounts.credit-notes.show', compact('creditNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditNoteReceived $creditNote)
    {
        $suppliers = Supplier::active()->get();
        $accounts = Account::supplier()->active()->get();

        return view('pos.accounts.credit-notes.edit', compact('creditNote', 'suppliers', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CreditNoteReceived $creditNote)
    {
        $validated = $request->validate([
            'credit_note_number' => 'required|string|unique:credit_notes_received,' . $creditNote->id,
            'supplier_id' => 'required|exists:suppliers,id',
            'account_id' => 'required|exists:accounts,id',
            'credit_note_date' => 'required|date',
            'original_purchase_date' => 'nullable|date',
            'original_invoice_number' => 'nullable|string|max:50',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        DB::transaction(function () use ($validated, $creditNote) {
            $oldStatus = $creditNote->status;
            $oldAmount = $creditNote->total_amount;

            $creditNote->update($validated);

            // Handle status change
            if ($oldStatus !== $creditNote->status) {
                // Remove old transaction if exists
                AccountTransaction::where([
                    'account_id' => $creditNote->account_id,
                    'reference_number' => $creditNote->credit_note_number,
                ])->delete();

                // Update account balance
                $account = $creditNote->account;
                if ($oldStatus === 'approved') {
                    $account->current_balance += $oldAmount;
                }

                if ($creditNote->status === 'approved') {
                    AccountTransaction::create([
                        'account_id' => $creditNote->account_id,
                        'transaction_type' => 'credit',
                        'amount' => $creditNote->total_amount,
                        'description' => "Credit Note: {$creditNote->credit_note_number}",
                        'transaction_date' => $creditNote->credit_note_date,
                        'reference_number' => $creditNote->credit_note_number,
                        'created_by' => $creditNote->created_by,
                    ]);

                    $account->current_balance -= $creditNote->total_amount;
                }

                $account->save();
            }
        });

        return redirect()->route('credit-notes.index')
            ->with('success', 'Credit note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditNoteReceived $creditNote)
    {
        DB::transaction(function () use ($creditNote) {
            // Remove transaction if exists
            AccountTransaction::where([
                'account_id' => $creditNote->account_id,
                'reference_number' => $creditNote->credit_note_number,
            ])->delete();

            // Update account balance if approved
            if ($creditNote->status === 'approved') {
                $account = $creditNote->account;
                $account->current_balance += $creditNote->total_amount;
                $account->save();
            }

            $creditNote->delete();
        });

        return redirect()->route('credit-notes.index')
            ->with('success', 'Credit note deleted successfully.');
    }
}

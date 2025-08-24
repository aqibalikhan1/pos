<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\SupplierPayment;
use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        
        // Get statistics for status cards
        $totalSuppliers = Supplier::count();
        $activeSuppliers = Supplier::where('is_active', true)->count();
        $inactiveSuppliers = Supplier::where('is_active', false)->count();
        $recentSuppliers = Supplier::latest()->take(5)->count();

        return view('pos.suppliers.index', compact(
            'suppliers',
            'totalSuppliers',
            'activeSuppliers',
            'inactiveSuppliers',
            'recentSuppliers',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pos.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'tax_number' => 'nullable|string|max:50',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'required|in:Cash,15 Days,30 Days,45 Days,60 Days',
            'supplier_type' => 'required|in:Manufacturer,Distributor,Wholesaler,Retailer,Importer',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $supplier = Supplier::create($validated);

        // Create account for the supplier
        $account = Account::create([
            'account_name' => $supplier->company_name,
            'account_type' => 'supplier',
            'accountable_type' => Supplier::class,
            'accountable_id' => $supplier->id,
            'account_number' => 'SUPP-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'current_balance' => 0,
            'opening_balance' => 0,
            'credit_limit' => $supplier->credit_limit ?? 0,
            'is_active' => $supplier->is_active ?? true,
            'created_by' => auth()->id(),
            'description' => 'Auto-generated account for supplier ' . $supplier->company_name
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully with account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        // Load account information
        $account = Account::where('accountable_type', Supplier::class)
            ->where('accountable_id', $supplier->id)
            ->first();

        // Load recent payments
        $recentPayments = SupplierPayment::where('supplier_id', $supplier->id)
            ->with(['account', 'purchase'])
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();

        // Load account transactions
        $transactions = AccountTransaction::where('account_id', $account->id ?? null)
            ->with(['reference'])
            ->orderBy('transaction_date', 'desc')
            ->take(10)
            ->get();

        // Load supplier with relationships for financial calculations
        $supplier->load(['purchases', 'supplierPayments']);

        return view('pos.suppliers.show', compact(
            'supplier',
            'account',
            'recentPayments',
            'transactions'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('pos.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'tax_number' => 'nullable|string|max:50',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'required|in:Cash,15 Days,30 Days,45 Days,60 Days',
            'supplier_type' => 'required|in:Manufacturer,Distributor,Wholesaler,Retailer,Importer',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}

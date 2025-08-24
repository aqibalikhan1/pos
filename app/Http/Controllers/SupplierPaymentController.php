<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Services\SupplierAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    protected $supplierAccountService;

    public function __construct(SupplierAccountService $supplierAccountService)
    {
        $this->supplierAccountService = $supplierAccountService;
    }

    public function index()
    {
        $supplierPayments = SupplierPayment::with(['supplier', 'purchase', 'creator'])->paginate(10);
        return view('pos.accounts.supplier-payments.index', compact('supplierPayments'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $purchases = Purchase::all();
        return view('pos.accounts.supplier-payments.create', compact('suppliers', 'purchases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_number' => 'required|string|max:255|unique:supplier_payments',
            'supplier_id' => 'required|integer',
            'purchase_id' => 'nullable|integer',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'created_by' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // Get or create supplier account first
            $supplier = Supplier::find($validated['supplier_id']);
            $account = $this->supplierAccountService->getOrCreateSupplierAccount($supplier);
            
            // Add account_id to the validated data
            $validated['account_id'] = $account->id;

            $supplierPayment = SupplierPayment::create($validated);
            
            // Create corresponding account transaction
            $this->supplierAccountService->createSupplierPaymentTransaction($supplierPayment);

            DB::commit();

            return redirect()->route('accounts.supplier-payments.index')->with('success', 'Supplier payment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create supplier payment: ' . $e->getMessage())->withInput();
        }
    }

    public function show(SupplierPayment $supplierPayment)
    {
        $supplierPayment->load(['supplier', 'purchase', 'creator', 'accountTransactions']);
        return view('pos.accounts.supplier-payments.show', compact('supplierPayment'));
    }

    public function edit(SupplierPayment $supplierPayment)
    {
        $suppliers = Supplier::all();
        $purchases = Purchase::all();
        return view('pos.accounts.supplier-payments.edit', compact('supplierPayment', 'suppliers', 'purchases'));
    }

    public function update(Request $request, SupplierPayment $supplierPayment)
    {
        $validated = $request->validate([
            'payment_number' => 'required|string|max:255|unique:supplier_payments,payment_number,' . $supplierPayment->id,
            'supplier_id' => 'required|integer',
            'purchase_id' => 'nullable|integer',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'created_by' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // Reverse the old transaction if amount changed
            if ($supplierPayment->amount != $validated['amount']) {
                $this->supplierAccountService->reverseSupplierPaymentTransaction($supplierPayment);
            }

            $supplierPayment->update($validated);

            // Create new transaction if amount changed
            if ($supplierPayment->amount != $validated['amount']) {
                $this->supplierAccountService->createSupplierPaymentTransaction($supplierPayment);
            }

            DB::commit();

            return redirect()->route('accounts.supplier-payments.index')->with('success', 'Supplier payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update supplier payment: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(SupplierPayment $supplierPayment)
    {
        try {
            DB::beginTransaction();

            // Reverse the transaction
            $this->supplierAccountService->reverseSupplierPaymentTransaction($supplierPayment);

            $supplierPayment->delete();

            DB::commit();

            return redirect()->route('accounts.supplier-payments.index')->with('success', 'Supplier payment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete supplier payment: ' . $e->getMessage());
        }
    }
}

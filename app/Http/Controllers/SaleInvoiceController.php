<?php

namespace App\Http\Controllers;

use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Services\TaxCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleInvoiceController extends Controller
{
    protected $taxCalculationService;

    public function __construct(TaxCalculationService $taxCalculationService)
    {
        $this->taxCalculationService = $taxCalculationService;
    }

    public function index()
    {
        $saleInvoices = SaleInvoice::with(['customer', 'employee', 'creator'])
            ->latest()
            ->paginate(20);

        return view('pos.sale-invoices.index', compact('saleInvoices'));
    }

    public function create()
    {
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $employees = Employee::where('is_active', true)->orderBy('first_name')->orderBy('last_name')->get();
        $products = Product::with('category')->orderBy('name')->get();
        $accounts = Account::orderBy('account_name')->get();

        return view('pos.sale-invoices.create', compact('customers', 'employees', 'products', 'accounts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'sale_date' => 'required|date',
            'due_date' => 'nullable|date',
            'sale_type' => 'required|string',
            'payment_method' => 'required|string',
            'items' => 'required|array',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate invoice number
            $lastInvoice = SaleInvoice::latest()->first();
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 5, '0', STR_PAD_LEFT);

            // Calculate totals using TaxCalculationService for sales
            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $itemTotal;
                $totalDiscount += $item['discount_amount'] ?? 0;

                // Use TaxCalculationService for sale tax calculation
                $taxResult = $this->taxCalculationService->calculateProductTax(
                    $product,
                    'sale', // Transaction type for sales
                    $validated['customer_id'], // Customer for sales
                    $item['quantity'],
                    $item['unit_price'],
                    $totalDiscount
                );

                $totalTax += $taxResult['tax_amount'];
            }

            $totalAmount = $subtotal - $totalDiscount + $totalTax;
            $dueAmount = $totalAmount - $validated['paid_amount'];

            // Create sale invoice
            $saleInvoice = SaleInvoice::create([
                'invoice_number' => $invoiceNumber,
                'employee_id' => $validated['employee_id'],
                'customer_id' => $validated['customer_id'],
                'sale_date' => $validated['sale_date'],
                'subtotal' => $subtotal,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'total_amount' => $totalAmount,
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $dueAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $dueAmount <= 0 ? 'paid' : ($validated['paid_amount'] > 0 ? 'partial' : 'pending'),
                'due_date' => $validated['due_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
                'sale_type' => $validated['sale_type'],
            ]);

            // Create sale invoice items
            foreach ($validated['items'] as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                
                SaleInvoiceItem::create([
                    'sale_invoice_id' => $saleInvoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $itemTotal - ($item['discount_amount'] ?? 0) + ($item['tax_amount'] ?? 0),
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'tax_amount' => $item['tax_amount'] ?? 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            // Create account transaction for cash sales
            if ($validated['sale_type'] === 'cash' && $validated['paid_amount'] > 0) {
                AccountTransaction::create([
                    'account_id' => $validated['account_id'],
                    'transaction_type' => 'credit',
                    'amount' => $validated['paid_amount'],
                    'description' => 'Sale Invoice Payment - ' . $invoiceNumber,
                    'transaction_date' => $validated['sale_date'],
                    'reference_type' => 'sale_invoice',
                    'reference_id' => $saleInvoice->id,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sale-invoices.show', $saleInvoice)
                ->with('success', 'Sale invoice created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating sale invoice: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error creating sale invoice. Please try again.');
        }
    }

    public function show(SaleInvoice $saleInvoice)
    {
        $saleInvoice->load(['customer', 'employee', 'creator', 'items.product', 'accountTransactions.account']);
        return view('pos.sale-invoices.show', compact('saleInvoice'));
    }

    public function edit(SaleInvoice $saleInvoice)
    {
        if ($saleInvoice->payment_status === 'paid') {
            return redirect()->route('sale-invoices.show', $saleInvoice)
                ->with('error', 'Cannot edit a fully paid invoice.');
        }

        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $employees = Employee::where('is_active', true)->orderBy('first_name')->orderBy('last_name')->get();
        $products = Product::with('category')->orderBy('name')->get();
        $accounts = Account::orderBy('account_name')->get();

        $saleInvoice->load('items');
        
        return view('pos.sale-invoices.edit', compact('saleInvoice', 'customers', 'employees', 'products', 'accounts'));
    }

    public function update(Request $request, SaleInvoice $saleInvoice)
    {
        if ($saleInvoice->payment_status === 'paid') {
            return redirect()->route('sale-invoices.show', $saleInvoice)
                ->with('error', 'Cannot update a fully paid invoice.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'sale_type' => 'required|in:cash,credit',
            'payment_method' => 'required|in:cash,credit,bank_transfer,cheque',
            'due_date' => 'nullable|date|after_or_equal:sale_date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals using TaxCalculationService for sales
            $subtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $itemTotal;
                $totalDiscount += $item['discount_amount'] ?? 0;

                // Use TaxCalculationService for sale tax calculation
                $taxResult = $this->taxCalculationService->calculateProductTax(
                    $product,
                    'sale', // Transaction type for sales
                    $validated['customer_id'], // Customer for sales
                    $item['quantity'],
                    $item['unit_price'],
                    $totalDiscount
                );

                $totalTax += $taxResult['tax_amount'];
            }

            $totalAmount = $subtotal - $totalDiscount + $totalTax;
            $dueAmount = $totalAmount - $validated['paid_amount'];

            // Update sale invoice
            $saleInvoice->update([
                'employee_id' => $validated['employee_id'],
                'customer_id' => $validated['customer_id'],
                'sale_date' => $validated['sale_date'],
                'subtotal' => $subtotal,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'total_amount' => $totalAmount,
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $dueAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $dueAmount <= 0 ? 'paid' : ($validated['paid_amount'] > 0 ? 'partial' : 'pending'),
                'due_date' => $validated['due_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'sale_type' => $validated['sale_type'],
            ]);

            // Delete existing items
            $saleInvoice->items()->delete();

            // Create new items
            foreach ($validated['items'] as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                
                SaleInvoiceItem::create([
                    'sale_invoice_id' => $saleInvoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $itemTotal - ($item['discount_amount'] ?? 0) + ($item['tax_amount'] ?? 0),
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'tax_amount' => $item['tax_amount'] ?? 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('sale-invoices.show', $saleInvoice)
                ->with('success', 'Sale invoice updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating sale invoice: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating sale invoice. Please try again.');
        }
    }

    public function destroy(SaleInvoice $saleInvoice)
    {
        if ($saleInvoice->payment_status !== 'pending') {
            return redirect()->route('sale-invoices.show', $saleInvoice)
                ->with('error', 'Cannot delete invoice with payments.');
        }

        DB::beginTransaction();
        try {
            $saleInvoice->items()->delete();
            $saleInvoice->accountTransactions()->delete();
            $saleInvoice->delete();

            DB::commit();
            return redirect()->route('sale-invoices.index')
                ->with('success', 'Sale invoice deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting sale invoice: ' . $e->getMessage());
            return back()->with('error', 'Error deleting sale invoice. Please try again.');
        }
    }

    public function print(SaleInvoice $saleInvoice)
    {
        $saleInvoice->load(['customer', 'employee', 'creator', 'items.product']);
        return view('pos.sale-invoices.print', compact('saleInvoice'));
    }

    public function getProducts()
    {
        $products = Product::with('category')->orderBy('name')->get();
        return response()->json($products);
    }

    public function getCustomers()
    {
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        return response()->json($customers);
    }
}

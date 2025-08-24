<?php

namespace App\Http\Controllers;

use App\Models\CreditSale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class CreditSaleController extends Controller
{
    public function index()
    {
        $creditSales = CreditSale::with(['customer'])->paginate(10);
        return view('pos.accounts.credit-sales.index', compact('creditSales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pos.accounts.credit-sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_number' => 'required|string|max:255|unique:credit_sales',
            'customer_id' => 'required|integer',
            'sale_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'created_by' => 'required|integer',
        ]);

        $creditSale = CreditSale::create($validated);
        return redirect()->route('accounts.credit-sales.index')->with('success', 'Credit sale created successfully.');
    }

    public function show(CreditSale $creditSale)
    {
        return view('pos.accounts.credit-sales.show', compact('creditSale'));
    }

    public function edit(CreditSale $creditSale)
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pos.accounts.credit-sales.edit', compact('creditSale', 'customers', 'products'));
    }

    public function update(Request $request, CreditSale $creditSale)
    {
        $validated = $request->validate([
            'sale_number' => 'required|string|max:255|unique:credit_sales,sale_number,' . $creditSale->id,
            'customer_id' => 'required|integer',
            'sale_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'created_by' => 'required|integer',
        ]);

        $creditSale->update($validated);
        return redirect()->route('accounts.credit-sales.index')->with('success', 'Credit sale updated successfully.');
    }

    public function destroy(CreditSale $creditSale)
    {
        $creditSale->delete();
        return redirect()->route('accounts.credit-sales.index')->with('success', 'Credit sale deleted successfully.');
    }
}

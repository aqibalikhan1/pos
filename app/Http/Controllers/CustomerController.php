<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use App\Models\Town;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        
        // Get statistics for status cards
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $inactiveCustomers = Customer::where('is_active', false)->count();
        $recentCustomers = Customer::latest()->take(5)->count();
        $taxFilers = Customer::where('is_filer', true)->count();

        return view('pos.customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers',
            'recentCustomers',
            'taxFilers'
        ));
    }

    public function create()
    {
        $companies = Company::where('is_active', true)->get();
        $towns = Town::where('status', true)->orderBy('name')->get();
        return view('pos.customers.create', compact('companies', 'towns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'town_id' => 'nullable|exists:towns,id',
            'is_active' => 'boolean',
            'is_filer' => 'boolean',
            'cnic' => 'nullable|string|max:15',
            'tax_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        // Conditional validation for filers
        if ($request->boolean('is_filer')) {
            $request->validate([
                'cnic' => 'required|string|max:15',
                'tax_number' => 'required|string|max:50',
            ]);
        }

        $customer = Customer::create($validated);

        // Create account for the customer
        $account = \App\Models\Account::create([
            'account_name' => $customer->full_name,
            'account_type' => 'customer',
            'accountable_type' => \App\Models\Customer::class,
            'accountable_id' => $customer->id,
            'account_number' => 'CUST-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'current_balance' => 0,
            'opening_balance' => 0,
            'is_active' => true,
            'created_by' => auth()->id(),
            'description' => 'Auto-generated account for customer ' . $customer->full_name
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully with account.');
    }

    public function show(Customer $customer)
    {
        return view('pos.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $companies = Company::where('is_active', true)->get();
        $towns = Town::where('status', true)->orderBy('name')->get();
        return view('pos.customers.edit', compact('customer', 'companies', 'towns'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'town_id' => 'nullable|exists:towns,id',
            'is_active' => 'boolean',
            'is_filer' => 'boolean',
            'cnic' => 'nullable|string|max:15',
            'tax_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        // Conditional validation for filers
        if ($request->boolean('is_filer')) {
            $request->validate([
                'cnic' => 'required|string|max:15',
                'tax_number' => 'required|string|max:50',
            ]);
        }

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}

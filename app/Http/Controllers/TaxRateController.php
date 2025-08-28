<?php

namespace App\Http\Controllers;

use App\Models\TaxRate;
use App\Models\TaxType;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index()
    {
        $taxRates = TaxRate::with('taxType')->paginate(10);
        return view('pos.tax-rates.index', compact('taxRates'));
    }

    public function create()
    {
        $taxTypes = TaxType::where('is_active', true)->get();
        return view('pos.tax-rates.create', compact('taxTypes'));
    }

    public function store(Request $request)
    {
        \Log::info('Store request data:', $request->all());
        
        $validated = $request->validate([
            'tax_type_id' => 'required|exists:tax_types,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
            'filer_rate' => 'nullable|numeric|min:0|max:100',
            'fixed_amount' => 'nullable|numeric|min:0',
            'effective_date' => 'required|date',
            'end_date' => 'nullable|date|after:effective_date',
            'is_active' => 'boolean'
        ]);

        TaxRate::create($validated);

        return redirect()->route('settings.tax-rates.index')
            ->with('success', 'Tax rate created successfully.');
    }

    public function edit(TaxRate $taxRate)
    {
        $taxTypes = TaxType::where('is_active', true)->get();
        return view('pos.tax-rates.edit', compact('taxRate', 'taxTypes'));
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        \Log::info('Update request data:', $request->all());
        
        $validated = $request->validate([
            'tax_type_id' => 'required|exists:tax_types,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
            'filer_rate' => 'nullable|numeric|min:0|max:100',
            'fixed_amount' => 'nullable|numeric|min:0',
            'effective_date' => 'required|date',
            'end_date' => 'nullable|date|after:effective_date',
            'is_active' => 'boolean'
        ]);

        $taxRate->update($validated);

        return redirect()->route('settings.tax-rates.index')
            ->with('success', 'Tax rate updated successfully.');
    }

    public function destroy(TaxRate $taxRate)
    {
        // Temporarily disable the product tax mapping check for testing
        // if ($taxRate->productTaxMappings()->exists()) {
        //     return redirect()->route('settings.tax-rates.index')
        //         ->with('error', 'Cannot delete tax rate with associated products.');
        // }

        $taxRate->delete();

        return redirect()->route('settings.tax-rates.index')
            ->with('success', 'Tax rate deleted successfully.');
    }
}

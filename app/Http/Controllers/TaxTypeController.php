<?php

namespace App\Http\Controllers;

use App\Models\TaxType;
use Illuminate\Http\Request;

class TaxTypeController extends Controller
{
    public function index()
    {
        $taxTypes = TaxType::with('taxRates')->paginate(10);
        return view('pos.tax-types.index', compact('taxTypes'));
    }

    public function create()
    {
        return view('pos.tax-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tax_types',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'is_active' => 'boolean'
        ]);

        TaxType::create($validated);

        return redirect()->route('settings.tax-types.index')
            ->with('success', 'Tax type created successfully.');
    }

    public function edit(TaxType $taxType)
    {
        return view('pos.tax-types.edit', compact('taxType'));
    }

    public function update(Request $request, TaxType $taxType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tax_types,code,' . $taxType->id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'is_active' => 'boolean'
        ]);

        $taxType->update($validated);

        return redirect()->route('settings.tax-types.index')
            ->with('success', 'Tax type updated successfully.');
    }

    public function destroy(TaxType $taxType)
    {
        if ($taxType->taxRates()->exists()) {
            return redirect()->route('settings.tax-types.index')
                ->with('error', 'Cannot delete tax type with associated rates.');
        }

        $taxType->delete();

        return redirect()->route('settings.tax-types.index')
            ->with('success', 'Tax type deleted successfully.');
    }
}

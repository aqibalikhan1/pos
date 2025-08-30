<?php

namespace App\Http\Controllers;

use App\Models\CurrencySetting;
use Illuminate\Http\Request;

class CurrencySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencySettings = CurrencySetting::all();
        return view('pos.currency-settings.index', compact('currencySettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pos.currency-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency_code' => 'required|string|max:3|unique:currency_settings',
            'currency_name' => 'required|string|max:100',
            'currency_symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle checkbox values - if not present in request, set to false
        $validated['is_default'] = $request->has('is_default');
        $validated['is_active'] = $request->has('is_active');

        // If this is set as default, unset any existing default
        if ($validated['is_default']) {
            CurrencySetting::where('is_default', true)->update(['is_default' => false]);
        }

        CurrencySetting::create($validated);

        // Clear config cache to reflect changes immediately
        \Artisan::call('config:clear');

        return redirect()->route('settings.currency-settings.index')
            ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CurrencySetting $currencySetting)
    {
        return view('pos.currency-settings.show', compact('currencySetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurrencySetting $currencySetting)
    {
        return view('pos.currency-settings.edit', compact('currencySetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurrencySetting $currencySetting)
    {
        $validated = $request->validate([
            'currency_code' => 'required|string|max:3|unique:currency_settings,currency_code,' . $currencySetting->id,
            'currency_name' => 'required|string|max:100',
            'currency_symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle checkbox values - if not present in request, set to false
        $validated['is_default'] = $request->has('is_default');
        $validated['is_active'] = $request->has('is_active');

        // If this is set as default, unset any existing default
        if ($validated['is_default']) {
            CurrencySetting::where('is_default', true)
                ->where('id', '!=', $currencySetting->id)
                ->update(['is_default' => false]);
        }

        $currencySetting->update($validated);

        // Clear config cache to reflect changes immediately
        \Artisan::call('config:clear');

        return redirect()->route('settings.currency-settings.index')
            ->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrencySetting $currencySetting)
    {
        // Prevent deletion of default currency
        if ($currencySetting->is_default) {
            return redirect()->route('settings.currency-settings.index')
                ->with('error', 'Cannot delete the default currency.');
        }

        $currencySetting->delete();

        return redirect()->route('settings.currency-settings.index')
            ->with('success', 'Currency deleted successfully.');
    }
}

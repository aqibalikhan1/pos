<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\ProductDataTable;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */

    public function index()
    {
          $products = Product::with(['category', 'company'])->get();
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'min_stock_level')->count();
        
        $totalValue = Product::selectRaw('SUM(purchase_price * stock_quantity) as total_value')->value('total_value');
        
        return view('pos.products.index', compact('products', 'lowStockCount', 'totalValue'));
    }

    public function getProducts()
    {
        return (new ProductDataTable())->ajax();
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $companies = \App\Models\Company::where('is_active', true)->get();
        // Fetch active tax rates
        $taxRates = \App\Models\TaxRate::active()->get();
        return view('pos.products.create', compact('categories', 'companies', 'taxRates'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products|max:100',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'trade_price' => 'required|numeric|min:0',
            'print_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'barcode' => 'nullable|string|max:50',
            'unit' => 'required|string|max:20',
            'pieces_per_pack' => 'required|integer|min:1',
            'packaging_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'tax_rates' => 'nullable|array',
            'tax_rates.*' => 'exists:tax_rates,id',
            'tax_rate_types' => 'nullable|array',
            'tax_rate_types.*' => 'in:sale,purchase,both',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $product = Product::create($validated);

        // Sync tax rates with transaction types if provided
        if ($request->has('tax_rates')) {
            $taxRatesWithTypes = [];
            foreach ($request->tax_rates as $taxRateId) {
                $transactionType = $request->tax_rate_types[$taxRateId] ?? 'both';
                $taxRatesWithTypes[$taxRateId] = ['transaction_type' => $transactionType];
            }
            $product->taxRates()->sync($taxRatesWithTypes);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'company', 'taxRates']);
        return view('pos.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $companies = \App\Models\Company::where('is_active', true)->get();
        // Fetch active tax rates and the product's current tax rates with pivot data
        $taxRates = \App\Models\TaxRate::active()->get();
        $product->load('taxRates');
        return view('pos.products.edit', compact('product', 'categories', 'companies', 'taxRates'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'trade_price' => 'required|numeric|min:0',
            'print_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'barcode' => 'nullable|string|max:50',
            'unit' => 'required|string|max:20',
            'pieces_per_pack' => 'required|integer|min:1',
            'packaging_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'tax_rates' => 'nullable|array',
            'tax_rates.*' => 'exists:tax_rates,id',
            'tax_rate_types' => 'nullable|array',
            'tax_rate_types.*' => 'in:sale,purchase,both',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        // Sync tax rates with transaction types if provided
        if ($request->has('tax_rates')) {
            $taxRatesWithTypes = [];
            foreach ($request->tax_rates as $taxRateId) {
                $transactionType = $request->tax_rate_types[$taxRateId] ?? 'both';
                $taxRatesWithTypes[$taxRateId] = ['transaction_type' => $transactionType];
            }
            $product->taxRates()->sync($taxRatesWithTypes);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Show the form for importing products.
     */
    public function importForm()
    {
        return view('pos.products.import');
    }

    /**
     * Handle the product import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ProductImport, $request->file('import_file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withFailures($failures);
        }

        return redirect()->route('products.index')->with('success', 'Products imported successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Category;
use App\Models\Account;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosTerminalController extends Controller
{
    /**
     * Display the POS terminal interface.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $customers = Customer::all();
        $employees = Employee::all();
        $categories = Category::all();
        $accounts = Account::all();

        return view('pos.terminal', compact('products', 'customers', 'employees', 'categories', 'accounts'));
    }

    /**
     * Search products for POS terminal.
     */
    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        
        $products = Product::with('category')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->where('stock_quantity', '>', 0)
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Get products by category.
     */
    public function getProductsByCategory($categoryId)
    {
        $products = Product::with('category')
            ->where('category_id', $categoryId)
            ->where('stock_quantity', '>', 0)
            ->get();

        return response()->json($products);
    }

    /**
     * Process the sale transaction.
     */
    public function processSale(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,mobile,bank_transfer,cheque',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $taxAmount = 0;
            $discountAmount = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                // Check stock availability
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock_quantity}");
                }

                $itemTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $itemTotal;
                
                // Update stock
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            // Calculate tax amount based on the products in the cart
            $taxRates = \App\Models\TaxRate::where('is_active', true)->get();
            foreach ($taxRates as $taxRate) {
                $taxAmount += ($subtotal * $taxRate->rate / 100);
            }

            $totalAmount = $subtotal - $discountAmount + $taxAmount;
            $dueAmount = $totalAmount - $request->paid_amount;

            // Create sale invoice (you can integrate with your existing SaleInvoice model)
            $saleData = [
                'customer_id' => $request->customer_id,
                'employee_id' => $request->employee_id,
                'sale_date' => now(),
                'sale_type' => $request->payment_method === 'cash' ? 'cash' : 'credit',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $dueAmount,
                'payment_status' => $dueAmount > 0 ? 'partial' : 'paid',
                'notes' => $request->notes,
            ];

            // Create sale invoice using the SaleInvoice model
            $saleInvoice = SaleInvoice::create($saleData);
            
            // Return success with invoice details
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale processed successfully',
                'total_amount' => $totalAmount,
                'due_amount' => $dueAmount,
                // 'invoice_id' => $saleInvoice->id,
                // 'invoice_number' => $saleInvoice->invoice_number,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Quick customer creation for POS.
     */
    public function quickCreateCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    /**
     * Get currency symbol for POS terminal.
     */
    public function getCurrencySymbol()
    {
        $currencyService = new CurrencyService();
        $symbol = $currencyService->getSymbol();
        
        return response()->json([
            'symbol' => $symbol
        ]);
    }
}

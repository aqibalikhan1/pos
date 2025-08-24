<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{

    /**
     * Display a listing of the purchases.
     */
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPurchases = Purchase::count();
        $pendingPurchases = Purchase::where('status', 'pending')->count();
        $totalAmount = Purchase::sum('total_amount');

        return view('pos.purchases.index', compact('purchases', 'totalPurchases', 'pendingPurchases', 'totalAmount'));
    }

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::with(['category', 'company'])->where('is_active', true)->get();
        
        return view('pos.purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:purchase_date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        // Generate unique purchase number
        $purchaseNumber = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // Calculate totals
        $subtotal = 0;
        $discountAmount = 0;

        foreach ($validated['items'] as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $itemDiscount = $itemTotal * ($item['discount_percent'] ?? 0) / 100;
            
            $subtotal += $itemTotal;
            $discountAmount += $itemDiscount;
        }

        $totalAmount = $subtotal - $discountAmount;

        // Get supplier account
        $supplier = Supplier::findOrFail($validated['supplier_id']);
        $account = $supplier->account;
        
        if (!$account) {
            return redirect()->back()
                ->with('error', 'Supplier does not have an associated account. Please create an account for this supplier first.')
                ->withInput();
        }

        // Create purchase
        $purchase = Purchase::create([
            'purchase_number' => $purchaseNumber,
            'supplier_id' => $validated['supplier_id'],
            'account_id' => $account->id,
            'purchase_date' => $validated['purchase_date'],
            'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // Create purchase items
        foreach ($validated['items'] as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $itemDiscount = $itemTotal * ($item['discount_percent'] ?? 0) / 100;
            $netAmount = $itemTotal - $itemDiscount;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $itemTotal,
                'discount_percent' => $item['discount_percent'] ?? 0,
                'discount_amount' => $itemDiscount,
                'net_amount' => $netAmount,
            ]);
        }

        // Create account transaction for the purchase
        $transactionNumber = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        $transaction = AccountTransaction::create([
            'transaction_number' => $transactionNumber,
            'account_id' => $account->id,
            'transaction_date' => $validated['purchase_date'],
            'transaction_type' => 'credit', // Credit for supplier (they owe us)
            'amount' => $totalAmount,
            'balance_after' => $account->current_balance + $totalAmount,
            'reference_type' => 'purchase',
            'reference_id' => $purchase->id,
            'payment_method' => 'credit',
            'description' => 'Purchase Order: ' . $purchaseNumber . ' - ' . $supplier->company_name,
            'created_by' => auth()->id(),
        ]);

        // Update account balance
        $account->current_balance += $totalAmount;
        $account->save();

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Purchase order created successfully with account transaction.');
    }

    /**
     * Display the specified purchase.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product', 'creator']);
        return view('pos.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified purchase.
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::with(['category', 'company'])->where('is_active', true)->get();
        
        return view('pos.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Update the specified purchase in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:purchase_date',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,ordered,partially_received,received,cancelled',
            'payment_status' => 'required|in:pending,partial,paid',
            'items' => 'sometimes|array|min:1',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $oldTotalAmount = $purchase->total_amount;
        
        // If items are being updated, recalculate totals and adjust stock
        if (isset($validated['items'])) {
            $subtotal = 0;
            $discountAmount = 0;

            // Get current items to calculate stock adjustments
            $currentItems = $purchase->items()->with('product')->get();
            $stockAdjustments = [];

            foreach ($validated['items'] as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemTotal * ($item['discount_percent'] ?? 0) / 100;
                
                $subtotal += $itemTotal;
                $discountAmount += $itemDiscount;
            }

            $totalAmount = $subtotal - $discountAmount;

            // Update purchase with new totals
            $purchase->update([
                'supplier_id' => $validated['supplier_id'],
                'invoice_no' => $validated['invoice_no'] ?? null,
                'purchase_date' => $validated['purchase_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Calculate stock adjustments for existing items
            foreach ($currentItems as $currentItem) {
                $newItem = collect($validated['items'])->firstWhere('product_id', $currentItem->product_id);
                
                if ($newItem) {
                    $quantityDifference = $newItem['quantity'] - $currentItem->quantity;
                    if ($quantityDifference != 0) {
                        $stockAdjustments[$currentItem->product_id] = $quantityDifference;
                    }
                } else {
                    // Item was removed, subtract the quantity
                    $stockAdjustments[$currentItem->product_id] = -$currentItem->quantity;
                }
            }

            // Add stock adjustments for new items
            foreach ($validated['items'] as $item) {
                $existingItem = $currentItems->firstWhere('product_id', $item['product_id']);
                if (!$existingItem) {
                    $stockAdjustments[$item['product_id']] = $item['quantity'];
                }
            }

            // Delete existing items and create new ones
            $purchase->items()->delete();
            
            foreach ($validated['items'] as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemTotal * ($item['discount_percent'] ?? 0) / 100;
                $netAmount = $itemTotal - $itemDiscount;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $itemTotal,
                    'discount_percent' => $item['discount_percent'] ?? 0,
                    'discount_amount' => $itemDiscount,
                    'net_amount' => $netAmount,
                ]);
            }

            // Update product stock if purchase is received
            if ($purchase->status === 'received') {
                foreach ($stockAdjustments as $productId => $adjustment) {
                    $product = Product::find($productId);
                    if ($product) {
                        $product->stock_quantity += $adjustment;
                        $product->save();
                    }
                }
            }

            // Update account transaction if total amount changed
            if ($totalAmount != $oldTotalAmount && $purchase->account) {
                $difference = $totalAmount - $oldTotalAmount;
                
                // Find the original transaction
                $transaction = AccountTransaction::where('reference_type', 'purchase')
                    ->where('reference_id', $purchase->id)
                    ->first();

                if ($transaction) {
                    // Update the transaction amount
                    $transaction->amount = $totalAmount;
                    $transaction->balance_after = $purchase->account->current_balance + $difference;
                    $transaction->description = 'Purchase Order: ' . $purchase->purchase_number . ' - ' . $purchase->supplier->company_name;
                    $transaction->save();

                    // Update account balance
                    $purchase->account->current_balance += $difference;
                    $purchase->account->save();
                }
            }
        } else {
            // Only update basic information
            $purchase->update([
                'supplier_id' => $validated['supplier_id'],
                'invoice_no' => $validated['invoice_no'] ?? null,
                'purchase_date' => $validated['purchase_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'notes' => $validated['notes'] ?? null,
            ]);
        }

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Purchase order updated successfully.');
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Mark purchase as received and update stock.
     */
    public function receive(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return redirect()->back()->with('error', 'Purchase already received.');
        }

        // Update stock for each item
        foreach ($purchase->items as $item) {
            $product = $item->product;
            $product->stock_quantity += $item->quantity;
            $product->save();
        }

        $purchase->update(['status' => 'received']);

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Purchase marked as received and stock updated.');
    }

    /**
     * Get products for purchase creation.
     */
    public function getProducts()
    {
        $products = Product::with(['category', 'company'])
            ->where('is_active', true)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'stock' => $product->stock_quantity,
                    'unit' => $product->unit,
                    'category' => $product->category->name ?? 'N/A',
                    'company' => $product->company->name ?? 'N/A',
                ];
            });

        return response()->json($products);
    }

    /**
     * Search products for purchase creation.
     */
    public function searchProducts(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 30;

        $query = Product::with(['category', 'company'])
            ->where('is_active', true);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'text' => $product->name . ' (' . $product->sku . ')',
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'stock' => $product->stock_quantity,
                'unit' => $product->unit,
                'category' => $product->category->name ?? 'N/A',
                'company' => $product->company->name ?? 'N/A',
            ];
        });

        return response()->json([
            'items' => $formattedProducts,
            'total_count' => $products->total()
        ]);
    }

}

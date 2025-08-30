@extends('layouts.material-app')

@section('title', 'Edit Purchase')
@section('page-title', 'Edit Purchase Order')
@section('breadcrumb', 'Edit Purchase')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Purchase Order #{{ $purchase->purchase_number }}</h2>

            <form method="POST" action="{{ route('purchases.update', $purchase->id) }}" class="space-y-6" id="purchaseForm">
                @csrf
                @method('PUT')

                <!-- Supplier and Date Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700">
                            Supplier <span class="text-red-500">*</span>
                        </label>
                        <select name="supplier_id" id="supplier_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="invoice_no" class="block text-sm font-medium text-gray-700">
                            Invoice No
                        </label>
                        <input type="text" name="invoice_no" id="invoice_no" 
                               value="{{ old('invoice_no', $purchase->invoice_no) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('invoice_no') border-red-500 @enderror"
                               placeholder="Enter invoice number">
                        @error('invoice_no')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium text-gray-700">
                            Purchase Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="purchase_date" id="purchase_date" 
                               value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('purchase_date') border-red-500 @enderror">
                        @error('purchase_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700">
                            Expected Delivery
                        </label>
                        <input type="date" name="expected_delivery_date" id="expected_delivery_date" 
                               value="{{ old('expected_delivery_date', $purchase->expected_delivery_date?->format('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('expected_delivery_date') border-red-500 @enderror">
                        @error('expected_delivery_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', $purchase->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ordered" {{ old('status', $purchase->status) == 'ordered' ? 'selected' : '' }}>Ordered</option>
                            <option value="partially_received" {{ old('status', $purchase->status) == 'partially_received' ? 'selected' : '' }}>Partially Received</option>
                            <option value="received" {{ old('status', $purchase->status) == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="cancelled" {{ old('status', $purchase->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">
                            Payment Status <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_status" id="payment_status" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('payment_status') border-red-500 @enderror">
                            <option value="pending" {{ old('payment_status', $purchase->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="partial" {{ old('payment_status', $purchase->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ old('payment_status', $purchase->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Products Section -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Products</h3>
                        <button type="button" id="addProductBtn" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            <i class="material-icons mr-2">add</i>
                            Add Product
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount %</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                @foreach($purchase->items as $index => $item)
                                    <tr class="product-row">
                                        <td class="px-6 py-4">
                                            <select name="items[{{ $index }}][product_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->purchase_price }}" 
                                                            data-name="{{ $product->name }}"
                                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} ({{ $product->sku }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" name="items[{{ $index }}][quantity]" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input" 
                                                   min="1" value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" required>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" name="items[{{ $index }}][unit_price]" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 price-input" 
                                                   min="0" step="0.01" value="{{ old('items.'.$index.'.unit_price', $item->unit_price) }}" required>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" name="items[{{ $index }}][discount_percent]" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 discount-input" 
                                                   min="0" max="100" step="0.01" value="{{ old('items.'.$index.'.discount_percent', $item->discount_percent) }}">
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium item-total">{{ config('currency.symbol') }}{{ number_format($item->net_amount, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg remove-product">
                                                <i class="material-icons text-base">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="noProductsMessage" class="text-center py-8 text-gray-500" style="display: none;">
                        <i class="material-icons text-4xl mb-2">inventory_2</i>
                        <p>No products added yet. Click "Add Product" to get started.</p>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-500 @enderror"
                                  placeholder="Enter any additional notes...">{{ old('notes', $purchase->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Summary</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Subtotal:</span>
                                <span class="text-sm font-medium" id="subtotal">{{ config('currency.symbol') }}{{ number_format($purchase->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Discount:</span>
                                <span class="text-sm font-medium" id="discount">{{ config('currency.symbol') }}{{ number_format($purchase->discount_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Tax:</span>
                                <span class="text-sm font-medium" id="tax">{{ config('currency.symbol') }}{{ number_format($purchase->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="text-lg font-semibold text-gray-900">Total:</span>
                                <span class="text-lg font-bold text-green-600" id="total">{{ config('currency.symbol') }}{{ number_format($purchase->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('purchases.show', $purchase->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        <i class="material-icons mr-2">save</i>
                        Update Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Product Template -->
<template id="productRowTemplate">
    <tr class="product-row">
        <td class="px-6 py-4">
            <select name="items[INDEX][product_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->purchase_price }}" 
                                                            data-name="{{ $product->name }}">
                                                        {{ $product->name }} ({{ $product->sku }})
                                                    </option>
                @endforeach
            </select>
        </td>
        <td class="px-6 py-4">
            <input type="number" name="items[INDEX][quantity]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input" min="1" value="1" required>
        </td>
        <td class="px-6 py-4">
            <input type="number" name="items[INDEX][unit_price]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 price-input" min="0" step="0.01" required>
        </td>
        <td class="px-6 py-4">
            <input type="number" name="items[INDEX][discount_percent]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 discount-input" min="0" max="100" step="0.01" value="0">
        </td>
        <td class="px-6 py-4">
            <span class="text-sm font-medium item-total">$0.00</span>
        </td>
        <td class="px-6 py-4">
            <button type="button" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg remove-product">
                <i class="material-icons text-base">delete</i>
            </button>
        </td>
    </tr>
</template>
@endsection

@push('scripts')
<script>
    let productIndex = {{ $purchase->items->count() }};

    function addProduct() {
        const template = document.getElementById('productRowTemplate').content.cloneNode(true);
        const row = template.querySelector('tr');
        
        // Update template indices
        row.innerHTML = row.innerHTML.replace(/INDEX/g, productIndex);
        
        document.getElementById('productsTableBody').appendChild(row);
        productIndex++;
        
        // Hide no products message
        document.getElementById('noProductsMessage').style.display = 'none';
        
        // Add event listeners
        attachRowEvents(row);
        calculateTotals();
    }

    function attachRowEvents(row) {
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        row.querySelector('.remove-product').addEventListener('click', function() {
            row.remove();
            if (document.querySelectorAll('.product-row').length === 0) {
                document.getElementById('noProductsMessage').style.display = 'block';
            }
            calculateTotals();
        });

        row.querySelector('.product-select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            row.querySelector('.price-input').value = price.toFixed(2);
            calculateTotals();
        });
    }

    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;

        document.querySelectorAll('.product-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const discountPercent = parseFloat(row.querySelector('.discount-input').value) || 0;
            const taxPercent = parseFloat(row.querySelector('.tax-input').value) || 0;

            const itemTotal = quantity * price;
            const itemDiscount = itemTotal * (discountPercent / 100);
            const itemTax = (itemTotal - itemDiscount) * (taxPercent / 100);
            const itemNet = itemTotal - itemDiscount + itemTax;

            row.querySelector('.item-total').textContent = '{{ config("currency.symbol") }}' + itemNet.toFixed(2);

            subtotal += itemTotal;
            totalDiscount += itemDiscount;
            totalTax += itemTax;
        });

        document.getElementById('subtotal').textContent = '{{ config("currency.symbol") }}' + subtotal.toFixed(2);
        document.getElementById('discount').textContent = '{{ config("currency.symbol") }}' + totalDiscount.toFixed(2);
        document.getElementById('tax').textContent = '{{ config("currency.symbol") }}' + totalTax.toFixed(2);
        document.getElementById('total').textContent = '{{ config("currency.symbol") }}' + (subtotal - totalDiscount + totalTax).toFixed(2);
    }

    // Initialize existing rows
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-row').forEach(row => {
            attachRowEvents(row);
        });
        calculateTotals();
    });

    document.getElementById('addProductBtn').addEventListener('click', addProduct);
</script>
@endpush

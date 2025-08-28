@extends('layouts.material-app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Sale Invoice</h1>
        <a href="{{ route('sale-invoices.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Back to List
        </a>
    </div>

    <form id="saleInvoiceForm" action="{{ route('sale-invoices.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer *</label>
                    <select name="customer_id" id="customer_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                <option value="{{ $customer->id }}" 
                        data-is-filer="{{ $customer->is_filer ? '1' : '0' }}"
                        data-tax-rate="{{ $customer->is_filer ? ($customer->filer_tax_rate ?? 18) : 18 }}">
                    {{ $customer->name }} ({{ $customer->is_filer ? 'Filer' : 'Non-Filer' }})
                </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee *</label>
                    <select name="employee_id" id="employee_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sale_date" class="block text-sm font-medium text-gray-700">Sale Date *</label>
                    <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('sale_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sale_type" class="block text-sm font-medium text-gray-700">Sale Type *</label>
                    <select name="sale_type" id="sale_type" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="cash" {{ old('sale_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="credit" {{ old('sale_type') == 'credit' ? 'selected' : '' }}>Credit</option>
                    </select>
                    @error('sale_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method *</label>
                    <select name="payment_method" id="payment_method" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Invoice Items</h2>
                <button type="button" id="addItemBtn" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Add Item
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Items will be added here dynamically -->
                    </tbody>
                </table>
            </div>

            @error('items')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('items.*')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700">Account (for cash sales)</label>
                    <select name="account_id" id="account_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="paid_amount" class="block text-sm font-medium text-gray-700">Paid Amount *</label>
                    <input type="number" name="paid_amount" id="paid_amount" value="{{ old('paid_amount', 0) }}" 
                           min="0" step="0.01" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('paid_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Summary -->
            <div class="mt-6 border-t pt-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Total Discount:</span>
                        <span id="totalDiscount">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Total Tax:</span>
                        <span id="totalTax">$0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold">
                        <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                        <span id="totalAmount">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Due Amount:</span>
                        <span id="dueAmount">$0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                    id="submitBtn">
                Create Invoice
            </button>
        </div>
    </form>
</div>

<!-- Item Template -->
<template id="itemTemplate">
    <tr class="item-row">
        <td class="px-6 py-4 whitespace-nowrap">
            <select name="items[][product_id]" required 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" 
                            data-price="{{ $product->sale_price ?? 0 }}"
                            data-category="{{ $product->category->name ?? '' }}">
                        {{ $product->name }} ({{ $product->category->name ?? 'No Category' }})
                    </option>
                @endforeach
            </select>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="number" name="items[][quantity]" value="1" min="0.01" step="0.01" required
                   class="block w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input">
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="number" name="items[][unit_price]" value="0" min="0" step="0.01" required
                   class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 price-input">
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="number" name="items[][discount_amount]" value="0" min="0" step="0.01"
                   class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 discount-input">
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="number" name="items[][tax_amount]" value="0" min="0" step="0.01"
                   class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 tax-input">
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="item-total">$0.00</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <button type="button" 
                    class="text-red-600 hover:text-red-900 remove-item">
                Remove
            </button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemCount = 0;
    const itemsTableBody = document.getElementById('itemsTableBody');
    const itemTemplate = document.getElementById('itemTemplate');
    const addItemBtn = document.getElementById('addItemBtn');
    const submitBtn = document.getElementById('submitBtn');

    // Add new item
    function addItem() {
        const template = itemTemplate.content.cloneNode(true);
        const row = template.querySelector('.item-row');
        
        // Update input names with proper indexing
        row.querySelectorAll('select, input').forEach(input => {
            if (input.name) {
                input.name = input.name.replace('[]', '[' + itemCount + ']');
            }
        });
        
        itemsTableBody.appendChild(template);
        itemCount++;
        
        // Add event listeners to new inputs
        attachEventListeners();
        calculateTotals();
    }

    // Remove item
    function removeItem(button) {
        button.closest('.item-row').remove();
        calculateTotals();
    }

    // Calculate totals
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
            const tax = parseFloat(row.querySelector('.tax-input').value) || 0;

            const itemTotal = (quantity * price) - discount + tax;
            subtotal += quantity * price;
            totalDiscount += discount;
            totalTax += tax;

            row.querySelector('.item-total').textContent = '$' + itemTotal.toFixed(2);
        });

        const totalAmount = subtotal - totalDiscount + totalTax;
        const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
        const dueAmount = totalAmount - paidAmount;

        document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('totalDiscount').textContent = '$' + totalDiscount.toFixed(2);
        document.getElementById('totalTax').textContent = '$' + totalTax.toFixed(2);
        document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
        document.getElementById('dueAmount').textContent = '$' + dueAmount.toFixed(2);
    }

    // Attach event listeners
    function attachEventListeners() {
        document.querySelectorAll('.quantity-input, .price-input, .discount-input, .tax-input').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        document.querySelectorAll('.product-select').forEach(select => {
            select.addEventListener('change', function() {
                const row = this.closest('.item-row');
                const selectedOption = this.options[this.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                row.querySelector('.price-input').value = price;
                calculateTotals();
            });
        });

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                removeItem(this);
            });
        });
    }

    // Customer change handler for tax calculation
    document.getElementById('customer_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const isFiler = selectedOption.dataset.isFiler === '1';
        const taxRate = parseFloat(selectedOption.dataset.taxRate) || 18;
        
        // Update tax for all items based on customer type
        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
            
            const taxableAmount = (price * quantity) - discount;
            const taxAmount = taxableAmount * (taxRate / 100);
            
            row.querySelector('.tax-input').value = taxAmount.toFixed(2);
        });
        
        calculateTotals();
    });

    // Event listeners
    addItemBtn.addEventListener('click', addItem);
    document.getElementById('paid_amount').addEventListener('input', calculateTotals);

    // Sale type change handler
    document.getElementById('sale_type').addEventListener('change', function() {
        const accountField = document.getElementById('account_id').closest('.grid').parentElement;
        if (this.value === 'cash') {
            accountField.style.display = 'block';
        } else {
            accountField.style.display = 'none';
        }
    });

    // Form validation
    document.getElementById('saleInvoiceForm').addEventListener('submit', function(e) {
        const items = document.querySelectorAll('.item-row');
        if (items.length === 0) {
            e.preventDefault();
            alert('Please add at least one item to the invoice.');
            return false;
        }

        let valid = true;
        items.forEach(row => {
            const productSelect = row.querySelector('.product-select');
            const quantity = row.querySelector('.quantity-input').value;
            const price = row.querySelector('.price-input').value;

            if (!productSelect.value || !quantity || !price) {
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields for each item.');
            return false;
        }
    });

    // Add first item on load
    addItem();
});
</script>
@endpush
@endsection

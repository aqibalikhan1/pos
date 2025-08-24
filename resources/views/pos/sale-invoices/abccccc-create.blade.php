@extends('layouts.material-app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 mb-8">
            <div class="px-8 py-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-3 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900">Create Sale Invoice</h1>
                            <p class="text-sm text-slate-600 mt-1">Generate a professional sales invoice for your customers</p>
                        </div>
                    </div>
                    <a href="{{ route('sale-invoices.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <form id="saleInvoiceForm" action="{{ route('sale-invoices.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Invoice Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Invoice Details
                    </h2>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div class="bg-slate-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Customer Information
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="customer_id" class="block text-sm font-medium text-slate-700 mb-2">Customer *</label>
                                        <select name="customer_id" id="customer_id" required 
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="employee_id" class="block text-sm font-medium text-slate-700 mb-2">Employee *</label>
                                        <select name="employee_id" id="employee_id" required 
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="bg-slate-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Invoice Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sale_date" class="block text-sm font-medium text-slate-700 mb-2">Sale Date *</label>
                                        <input type="date" name="sale_date" id="sale_date" required 
                                               value="{{ old('sale_date', now()->format('Y-m-d')) }}"
                                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                    </div>
                                    <div>
                                        <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">Due Date</label>
                                        <input type="date" name="due_date" id="due_date" 
                                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                    </div>
                                    <div>
                                        <label for="sale_type" class="block text-sm font-medium text-slate-700 mb-2">Sale Type *</label>
                                        <select name="sale_type" id="sale_type" required 
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="cash">💵 Cash Sale</option>
                                            <option value="credit">💳 Credit Sale</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="payment_method" class="block text-sm font-medium text-slate-700 mb-2">Payment Method *</label>
                                        <select name="payment_method" id="payment_method" required 
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                            <option value="cash">💵 Cash</option>
                                            <option value="credit">💳 Credit</option>
                                            <option value="bank_transfer">🏦 Bank Transfer</option>
                                            <option value="cheque">📝 Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                  placeholder="Add any additional notes or special instructions..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Invoice Items Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Invoice Items
                        </h2>
                        <button type="button" id="addItemBtn" 
                                class="inline-flex items-center px-4 py-2 bg-white text-green-700 rounded-lg hover:bg-green-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Item
                        </button>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Discount</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Tax</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceItemsBody" class="bg-white divide-y divide-slate-200">
                                <!-- Items will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <div id="emptyState" class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-slate-900">No items added</h3>
                        <p class="mt-2 text-sm text-slate-500">Get started by adding your first item to the invoice.</p>
                    </div>
                </div>
            </div>

            <!-- Payment Summary Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Payment Summary
                    </h2>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label for="paid_amount" class="block text-sm font-medium text-slate-700 mb-2">Paid Amount *</label>
                                <input type="number" name="paid_amount" id="paid_amount" step="0.01" min="0" required 
                                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            </div>
                            <div id="accountField" style="display: none;">
                                <label for="account_id" class="block text-sm font-medium text-slate-700 mb-2">Account *</label>
                                <select name="account_id" id="account_id" 
                                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                    <option value="">Select Account</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-slate-600">Subtotal:</span>
                                    <span class="text-lg font-semibold text-slate-900" id="subtotal">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-slate-600">Total:</span>
                                    <span class="text-2xl font-bold text-green-600" id="total">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Create Invoice
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let itemCount = 0;
    let products = @json($products);

    // Ensure DOM is loaded before adding event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const addItemBtn = document.getElementById('addItemBtn');
        if (addItemBtn) {
            addItemBtn.addEventListener('click', function() {
                addItem();
            });
        }

        const saleTypeSelect = document.getElementById('sale_type');
        if (saleTypeSelect) {
            saleTypeSelect.addEventListener('change', function() {
                const accountField = document.getElementById('accountField');
                if (accountField) {
                    accountField.style.display = this.value === 'cash' ? 'block' : 'none';
                }
            });
        }

        // Add initial item if no items exist
        if (document.getElementById('invoiceItemsBody').children.length === 0) {
            addItem();
        }
    });

    function addItem() {
        itemCount++;
        const tbody = document.getElementById('invoiceItemsBody');
        const emptyState = document.getElementById('emptyState');
        
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        const row = document.createElement('tr');
        row.className = 'hover:bg-slate-50 transition-colors';
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <select name="items[${itemCount}][product_id]" required 
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                        onchange="updateProductPrice(this)">
                    <option value="">Select Product</option>
                    ${products.filter(product => product.is_active && product.stock_quantity > 0).map(product => `<option value="${product.id}" data-stock="${product.stock_quantity}" data-price="${product.selling_price}">${product.name} (${product.stock_quantity} in stock)</option>`).join('')}
                </select>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" name="items[${itemCount}][quantity]" step="0.01" min="0.01" required 
                       class="block w-24 rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                       oninput="updateTotals(this)">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" name="items[${itemCount}][unit_price]" step="0.01" min="0" required 
                       class="block w-32 rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                       oninput="updateTotals(this)">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" name="items[${itemCount}][discount_amount]" step="0.01" min="0" value="0"
                       class="block w-32 rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                       oninput="updateTotals(this)">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" name="items[${itemCount}][tax_amount]" step="0.01" min="0" value="0"
                       class="block w-32 rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors"
                       oninput="updateTotals(this)">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="item-total font-semibold text-slate-900">$0.00</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button type="button" onclick="removeItem(this)" 
                        class="text-red-600 hover:text-red-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 
                              01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-6 0V5a2 2 0 
                              012-2h2a2 2 0 012 2v2" />
                    </svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function removeItem(button) {
        const row = button.closest('tr');
        row.remove();

        const tbody = document.getElementById('invoiceItemsBody');
        if (tbody.children.length === 0) {
            const emptyState = document.getElementById('emptyState');
            if (emptyState) emptyState.style.display = 'block';
        }

        calculateTotals();
    }

    function updateProductPrice(select) {
        const option = select.options[select.selectedIndex];
        if (option && option.dataset.price) {
            const row = select.closest('tr');
            const priceInput = row.querySelector('input[name*="[unit_price]"]');
            if (priceInput) {
                priceInput.value = option.dataset.price;
            }
        }
        updateTotals(select);
    }

    function updateTotals(input) {
        const row = input.closest('tr');
        const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
        const discount = parseFloat(row.querySelector('input[name*="[discount_amount]"]').value) || 0;
        const tax = parseFloat(row.querySelector('input[name*="[tax_amount]"]').value) || 0;

        let total = (quantity * unitPrice) - discount + tax;
        if (total < 0) total = 0;

        const totalCell = row.querySelector('.item-total');
        if (totalCell) {
            totalCell.textContent = `$${total.toFixed(2)}`;
        }

        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        let total = 0;

        document.querySelectorAll('#invoiceItemsBody tr').forEach(row => {
            const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
            const unitPrice = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
            const discount = parseFloat(row.querySelector('input[name*="[discount_amount]"]').value) || 0;
            const tax = parseFloat(row.querySelector('input[name*="[tax_amount]"]').value) || 0;

            let itemTotal = (quantity * unitPrice) - discount + tax;
            if (itemTotal < 0) itemTotal = 0;

            subtotal += (quantity * unitPrice);
            total += itemTotal;
        });

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }
</script>
@endpush
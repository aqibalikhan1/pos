@extends('layouts.material-app')

@section('title', 'Main Dashboard')
@section('page-title', 'Main Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Quick Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="material-icons">attach_money</i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ \App\Helpers\CurrencyHelper::formatAmount(\App\Models\SaleInvoice::sum('total_amount')) }}
                                </p>
                            </div>
                        </div>
                        <div class="text-green-500 flex items-center">
                            <i class="material-icons text-sm">trending_up</i>
                            <span class="text-sm ml-1">12.5%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Customers</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Customer::count() }}</p>
                            </div>
                        </div>
                        <div class="text-green-500 flex items-center">
                            <i class="material-icons text-sm">trending_up</i>
                            <span class="text-sm ml-1">15.3%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suppliers Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="material-icons">local_shipping</i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Suppliers</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Supplier::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="material-icons">receipt</i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Sales</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\SaleInvoice::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modules Grid Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- POS Module Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-blue-600 mr-2">point_of_sale</i>
                        POS System
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('pos.dashboard') }}" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">dashboard</i>
                            POS Dashboard
                        </a>
                        <a href="{{ route('products.index') }}" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">inventory</i>
                            Products Management
                        </a>
                        <a href="{{ route('sale-invoices.index') }}" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">receipt</i>
                            Sale Invoices
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventory Module Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-green-600 mr-2">inventory_2</i>
                        Inventory Management
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('categories.index') }}" class="block px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">category</i>
                            Categories
                        </a>
                        <a href="{{ route('companies.index') }}" class="block px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">business</i>
                            Companies
                        </a>
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">payments</i>
                            Purchases
                        </a>
                    </div>
                </div>
            </div>

            <!-- Customer Management Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-purple-600 mr-2">people</i>
                        Customer Management
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('customers.index') }}" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">person</i>
                            Customers
                        </a>
                        <a href="{{ route('towns.index') }}" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">location_city</i>
                            Towns
                        </a>
                        <a href="{{ route('routes.index') }}" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">route</i>
                            Routes
                        </a>
                        <a href="{{ route('employees.index') }}" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">badge</i>
                            Employees
                        </a>
                    </div>
                </div>
            </div>

            <!-- Supplier Management Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-orange-600 mr-2">local_shipping</i>
                        Supplier Management
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('suppliers.index') }}" class="block px-4 py-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">inventory</i>
                            Suppliers
                        </a>
                        <a href="{{ route('accounts.supplier-payments.index') }}" class="block px-4 py-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">payment</i>
                            Supplier Payments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Accounting Module Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-red-600 mr-2">account_balance</i>
                        Accounting
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('accounts.index') }}" class="block px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">account_balance_wallet</i>
                            Accounts
                        </a>
                        <a href="{{ route('accounts.transactions.index') }}" class="block px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">receipt_long</i>
                            Transactions
                        </a>
                        <a href="{{ route('accounts.credit-sales.index') }}" class="block px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">shopping_cart</i>
                            Credit Sales
                        </a>
                        <a href="{{ route('credit-notes.index') }}" class="block px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">note</i>
                            Credit Notes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Expenses Module Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-indigo-600 mr-2">paid</i>
                        Expenses
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('expenses.index') }}" class="block px-4 py-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">receipt</i>
                            Expenses
                        </a>
                        <a href="{{ route('expenses.summary') }}" class="block px-4 py-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors flex items-center">
                            <i class="material-icons text-sm mr-2">summarize</i>
                            Expense Summary
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Products Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-blue-600 mr-2">inventory</i>
                        Recent Products
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">SKU</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Product::latest()->take(5)->get() as $product)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->sku }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $product->stock_quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Sales Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons text-green-600 mr-2">receipt</i>
                        Recent Sales
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Invoice #</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Customer</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\SaleInvoice::latest()->take(5)->get() as $invoice)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $invoice->invoice_number }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $invoice->customer->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ \App\Helpers\CurrencyHelper::formatAmount($invoice->total_amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

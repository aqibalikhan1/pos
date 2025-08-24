@extends('layouts.material-app')

@section('title', 'Supplier Details')
@section('page-title', 'Supplier Details')
@section('breadcrumb', 'Suppliers / Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Supplier Information -->
    <div class="lg:col-span-2">
        <div class="md-card">
            <div class="md-card-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="md-card-title">{{ $supplier->company_name }}</h2>
                        <p class="text-sm text-gray-600">{{ $supplier->contact_name }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $supplier->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="md-card-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $supplier->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $supplier->phone ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Mobile</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $supplier->mobile ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Business Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Business Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Supplier Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($supplier->supplier_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Terms</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $supplier->payment_terms }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tax Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $supplier->tax_number ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Address</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">
                            {{ $supplier->address ?? 'No address provided' }}<br>
                            {{ $supplier->city ?? '' }}{{ $supplier->city && $supplier->state ? ', ' : '' }}{{ $supplier->state ?? '' }}<br>
                            {{ $supplier->zip_code ?? '' }} {{ $supplier->country ?? 'Pakistan' }}
                        </p>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-blue-900">Total Purchases</dt>
                            <dd class="mt-1 text-2xl font-semibold text-blue-600">Rs {{ number_format($supplier->total_purchases, 2) }}</dd>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-green-900">Total Payments</dt>
                            <dd class="mt-1 text-2xl font-semibold text-green-600">Rs {{ number_format($supplier->total_payments, 2) }}</dd>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-red-900">Outstanding Balance</dt>
                            <dd class="mt-1 text-2xl font-semibold text-red-600">Rs {{ number_format($supplier->outstanding_balance, 2) }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Purchase Statistics -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Purchase Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($supplier->purchase_statistics as $status => $data)
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-yellow-900">{{ ucfirst($status) }} Purchases</dt>
                            <dd class="mt-1 text-2xl font-semibold text-yellow-600">{{ $data['count'] }} (Rs {{ number_format($data['total_amount'], 2) }})</dd>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Statistics -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($supplier->payment_statistics as $method => $data)
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-purple-900">{{ ucfirst($method) }} Payments</dt>
                            <dd class="mt-1 text-2xl font-semibold text-purple-600">{{ $data['count'] }} (Rs {{ number_format($data['total_amount'], 2) }})</dd>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Aging Analysis -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aging Analysis</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">Current</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-600">Rs {{ number_format($supplier->aging_analysis['current'], 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">1-30 Days</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-600">Rs {{ number_format($supplier->aging_analysis['1-30'], 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">31-60 Days</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-600">Rs {{ number_format($supplier->aging_analysis['31-60'], 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">61-90 Days</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-600">Rs {{ number_format($supplier->aging_analysis['61-90'], 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">Over 90 Days</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-600">Rs {{ number_format($supplier->aging_analysis['over_90'], 2) }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                @if($account)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-purple-900">Account Number</dt>
                            <dd class="mt-1 text-lg font-semibold text-purple-600">{{ $account->account_number }}</dd>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-orange-900">Account Balance</dt>
                            <dd class="mt-1 text-2xl font-semibold text-orange-600">Rs {{ number_format($account->current_balance, 2) }}</dd>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">Opening Balance</dt>
                            <dd class="mt-1 text-lg text-gray-700">Rs {{ number_format($account->opening_balance, 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dt class="text-sm font-medium text-gray-900">Account Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Payments -->
                @if($recentPayments->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Payments</h3>
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Payment #</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Method</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Reference</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($recentPayments as $payment)
                                <tr>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $payment->payment_number }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">Rs {{ number_format($payment->amount, 2) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $payment->payment_method }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $payment->reference_number ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Recent Transactions -->
                @if($transactions->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Account Transactions</h3>
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Reference</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->transaction_type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->transaction_type) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">Rs {{ number_format($transaction->amount, 2) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ $transaction->description }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        @if($transaction->reference)
                                            {{ $transaction->reference->payment_number ?? $transaction->reference->reference_number ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($supplier->notes)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $supplier->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Actions Card -->
        <div class="md-card mb-6">
            <div class="md-card-header">
                <h2 class="md-card-title">Actions</h2>
            </div>
            <div class="md-card-content">
                <div class="space-y-3">
                    <a href="{{ route('suppliers.edit', $supplier) }}" 
                       class="w-full md-button md-button-primary">
                        <i class="material-icons mr-2">edit</i>
                        Edit Supplier
                    </a>
                    <a href="{{ route('suppliers.index') }}" 
                       class="w-full md-button md-button-secondary">
                        <i class="material-icons mr-2">arrow_back</i>
                        Back to List
                    </a>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full md-button md-button-danger"
                                onclick="return confirm('Are you sure you want to delete this supplier?')">
                            <i class="material-icons mr-2">delete</i>
                            Delete Supplier
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="md-card">
            <div class="md-card-header">
                <h2 class="md-card-title">System Information</h2>
            </div>
            <div class="md-card-content">
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $supplier->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $supplier->updated_at->format('M d, Y h:i A') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

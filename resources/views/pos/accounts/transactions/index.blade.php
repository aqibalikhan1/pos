@extends('layouts.material-app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Account Transactions</h1>
        <a href="{{ route('accounts.transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            <i class="material-icons text-sm mr-1">add</i>
            Create Transaction
        </a>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('accounts.transactions.index') }}" class="flex items-center space-x-4">
            <select name="transaction_type" class="border rounded-md p-2">
                <option value="">All Types</option>
                <option value="debit" {{ request('transaction_type') == 'debit' ? 'selected' : '' }}>Debit</option>
                <option value="credit" {{ request('transaction_type') == 'credit' ? 'selected' : '' }}>Credit</option>
            </select>
            <select name="reference_type" class="border rounded-md p-2">
                <option value="">All References</option>
                <option value="purchase" {{ request('reference_type') == 'purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="sale" {{ request('reference_type') == 'sale' ? 'selected' : '' }}>Sale</option>
                <option value="expense" {{ request('reference_type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
            <select name="supplier_id" class="border rounded-md p-2">
                <option value="">All Suppliers</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                @endforeach
            </select>
            <input type="date" name="start_date" class="border rounded-md p-2" placeholder="Start Date" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="border rounded-md p-2" placeholder="End Date" value="{{ request('end_date') }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Filter</button>
            <a href="{{ route('accounts.transactions.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Clear</a>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->transaction_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->account->account_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($transaction->transaction_type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs {{ $transaction->formatted_amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs {{ $transaction->balance_after }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->payment_method }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('accounts.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                <i class="material-icons text-sm">visibility</i>
                            </a>
                            <a href="{{ route('accounts.transactions.edit', $transaction) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                <i class="material-icons text-sm">edit</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection

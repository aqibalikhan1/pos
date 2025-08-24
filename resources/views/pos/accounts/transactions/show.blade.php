@extends('layouts.material-app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Transaction Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('accounts.transactions.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="material-icons text-sm mr-1">arrow_back</i>
                    Back to List
                </a>
                <a href="{{ route('accounts.transactions.edit', $transaction) }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    <i class="material-icons text-sm mr-1">edit</i>
                    Edit
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Transaction Information</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Basic Details</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Transaction Number:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->transaction_number }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Account:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->account->account_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Transaction Date:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->transaction_date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Transaction Type:</span>
                                <span class="ml-2 text-gray-900 font-semibold {{ $transaction->transaction_type === 'debit' ? 'text-red-600' : 'text-green-600' }}">
                                    {{ ucfirst($transaction->transaction_type) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Amount:</span>
                                <span class="ml-2 text-gray-900 font-semibold">Rs {{ number_format($transaction->amount, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Balance After:</span>
                                <span class="ml-2 text-gray-900">Rs {{ number_format($transaction->balance_after, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Additional Details</h3>
                        <div class="space-y-3">
                            @if($transaction->relatedAccount)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Related Account:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->relatedAccount->account_name }}</span>
                            </div>
                            @endif
                            
                            <div>
                                <span class="text-sm font-medium text-gray-600">Payment Method:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : 'N/A' }}</span>
                            </div>
                            
                            @if($transaction->cheque_number)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Cheque Number:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->cheque_number }}</span>
                            </div>
                            @endif
                            
                            @if($transaction->cheque_date)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Cheque Date:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->cheque_date->format('d/m/Y') }}</span>
                            </div>
                            @endif
                            
                            @if($transaction->reference_type && $transaction->reference_id)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Reference:</span>
                                <span class="ml-2 text-gray-900">
                                    {{ ucfirst($transaction->reference_type) }} #{{ $transaction->reference_id }}
                                    @if($transaction->reference_type === 'purchase')
                                    - 
                                    <a href="{{ route('purchases.show', $transaction->reference_id) }}" 
                                       class="text-indigo-600 hover:text-indigo-800 underline">
                                        View Purchase Order
                                    </a>
                                    @endif
                                </span>
                            </div>
                            @endif
                            
                            <div>
                                <span class="text-sm font-medium text-gray-600">Created By:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->creator->name ?? 'System' }}</span>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-600">Created At:</span>
                                <span class="ml-2 text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($transaction->description)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Description</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-700">{{ $transaction->description }}</p>
                    </div>
                </div>
                @endif

                <div class="mt-8 flex justify-between items-center">
                    <div>
                        <span class="text-sm text-gray-600">Last updated: {{ $transaction->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex space-x-3">
                        <form action="{{ route('accounts.transactions.destroy', $transaction) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                                <i class="material-icons text-sm mr-1">delete</i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

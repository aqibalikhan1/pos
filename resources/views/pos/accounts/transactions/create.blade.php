@extends('layouts.material-app')

@section('title', 'Create Account Transaction')
@section('page-title', 'Create New Account Transaction')
@section('breadcrumb', 'Create Transaction')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Transaction Details</h2>
        </div>
        
        <div class="md-card-content">
            <form action="{{ route('accounts.transactions.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700">Account *</label>
                    <select name="account_id" id="account_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('account_id') border-red-500 @enderror" 
                            required>
                        <option value="">Select Account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->account_name }} - {{ $account->account_type }}
                            </option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="transaction_type" class="block text-sm font-medium text-gray-700">Transaction Type *</label>
                    <select name="transaction_type" id="transaction_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('transaction_type') border-red-500 @enderror" 
                            required>
                        <option value="">Select Type</option>
                        <option value="credit" {{ old('transaction_type') == 'credit' ? 'selected' : '' }}>Credit (Deposit)</option>
                        <option value="debit" {{ old('transaction_type') == 'debit' ? 'selected' : '' }}>Debit (Withdrawal)</option>
                    </select>
                    @error('transaction_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                    <input type="number" step="0.01" name="amount" id="amount" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('amount') border-red-500 @enderror" 
                           value="{{ old('amount') }}" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Transaction Date *</label>
                    <input type="date" name="transaction_date" id="transaction_date" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('transaction_date') border-red-500 @enderror" 
                           value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method *</label>
                    <select name="payment_method" id="payment_method" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('payment_method') border-red-500 @enderror" 
                            required>
                        <option value="">Select Method</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reference_number" class="block text-sm font-medium text-gray-700">Reference Number</label>
                    <input type="text" name="reference_number" id="reference_number" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('reference_number') border-red-500 @enderror" 
                           value="{{ old('reference_number') }}" placeholder="e.g. CHQ-001, TXN-123">
                    @error('reference_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('description') border-red-500 @enderror"
                              placeholder="Enter transaction details...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('accounts.transactions.index') }}" 
                       class="md-button bg-gray-300 text-gray-700 hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="md-button md-button-primary">
                        <i class="material-icons mr-2">save</i>
                        Create Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate reference number if empty
        const refInput = document.getElementById('reference_number');
        if (!refInput.value) {
            const timestamp = new Date().getTime();
            refInput.value = 'TXN-' + timestamp.toString().slice(-6);
        }
    });
</script>
@endpush

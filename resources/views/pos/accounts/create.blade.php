@extends('layouts.material-app')
@section('title', 'Create Account')
@section('page-title', 'Add New Account')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Account</h2>

            <form method="POST" action="{{ route('accounts.store') }}" class="space-y-6">
                @csrf

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name *</label>
                            <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('account_name') border-red-500 @enderror">
                            @error('account_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type *</label>
                            <select name="account_type" id="account_type" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('account_type') border-red-500 @enderror">
                                <option value="">Select an account type</option>
                                <option value="customer" {{ old('account_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="supplier" {{ old('account_type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                <option value="expense" {{ old('account_type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                <option value="income" {{ old('account_type') == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="asset" {{ old('account_type') == 'asset' ? 'selected' : '' }}>Asset</option>
                                <option value="liability" {{ old('account_type') == 'liability' ? 'selected' : '' }}>Liability</option>
                            </select>
                            @error('account_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="opening_balance" class="block text-sm font-medium text-gray-700">Opening Balance</label>
                            <input type="number" name="opening_balance" id="opening_balance" value="{{ old('opening_balance') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('opening_balance') border-red-500 @enderror">
                            @error('opening_balance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credit_limit" class="block text-sm font-medium text-gray-700">Credit Limit</label>
                            <input type="number" name="credit_limit" id="credit_limit" value="{{ old('credit_limit') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('credit_limit') border-red-500 @enderror">
                            @error('credit_limit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Save Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

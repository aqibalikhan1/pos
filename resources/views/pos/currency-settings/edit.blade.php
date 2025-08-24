@extends('layouts.material-app')

@section('title', 'Edit Currency')
@section('page-title', 'Edit Currency')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Edit Currency</h2>
            </div>

            <form action="{{ route('settings.currency-settings.update', $currencySetting) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-4">
                    <div>
                        <label for="currency_name" class="block text-sm font-medium text-gray-700">Currency Name</label>
                        <input type="text" 
                               name="currency_name" 
                               id="currency_name" 
                               value="{{ old('currency_name', $currencySetting->currency_name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('currency_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="currency_code" class="block text-sm font-medium text-gray-700">Currency Code</label>
                        <input type="text" 
                               name="currency_code" 
                               id="currency_code" 
                               value="{{ old('currency_code', $currencySetting->currency_code) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               maxlength="3"
                               required>
                        @error('currency_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="currency_symbol" class="block text-sm font-medium text-gray-700">Symbol</label>
                        <input type="text" 
                               name="currency_symbol" 
                               id="currency_symbol" 
                               value="{{ old('currency_symbol', $currencySetting->currency_symbol) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('currency_symbol')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="exchange_rate" class="block text-sm font-medium text-gray-700">Exchange Rate</label>
                        <input type="number" 
                               name="exchange_rate" 
                               id="exchange_rate" 
                               value="{{ old('exchange_rate', $currencySetting->exchange_rate) }}"
                               step="0.0001"
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('exchange_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_default" 
                               id="is_default" 
                               value="1"
                               {{ old('is_default', $currencySetting->is_default) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_default" class="ml-2 block text-sm text-gray-900">
                            Set as default currency
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', $currencySetting->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active
                        </label>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('settings.currency-settings.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Update Currency
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

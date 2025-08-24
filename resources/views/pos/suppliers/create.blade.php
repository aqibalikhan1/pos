@extends('layouts.material-app')

@section('title', 'Create Supplier')
@section('page-title', 'Create New Supplier')
@section('breadcrumb', 'Suppliers / Create')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Form Card -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Add New Supplier</h2>
            <p class="text-sm text-gray-600">Fill in the details below to add a new supplier to your system.</p>
        </div>
        
        <div class="md-card-content">
            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Company Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="company_name" 
                               id="company_name" 
                               value="{{ old('company_name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700">
                            Contact Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="contact_name" 
                               id="contact_name" 
                               value="{{ old('contact_name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700">
                            Mobile Number
                        </label>
                        <input type="tel" 
                               name="mobile" 
                               id="mobile" 
                               value="{{ old('mobile') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tax_number" class="block text-sm font-medium text-gray-700">
                            Tax Number
                        </label>
                        <input type="text" 
                               name="tax_number" 
                               id="tax_number" 
                               value="{{ old('tax_number') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('tax_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Information -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        Address
                    </label>
                    <textarea name="address" 
                              id="address" 
                              rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city" 
                               value="{{ old('city') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">
                            State/Province
                        </label>
                        <input type="text" 
                               name="state" 
                               id="state" 
                               value="{{ old('state') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700">
                            ZIP/Postal Code
                        </label>
                        <input type="text" 
                               name="zip_code" 
                               id="zip_code" 
                               value="{{ old('zip_code') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('zip_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">
                            Country
                        </label>
                        <input type="text" 
                               name="country" 
                               id="country" 
                               value="{{ old('country', 'Pakistan') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="credit_limit" class="block text-sm font-medium text-gray-700">
                            Credit Limit
                        </label>
                        <input type="number" 
                               name="credit_limit" 
                               id="credit_limit" 
                               step="0.01"
                               value="{{ old('credit_limit', 0) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('credit_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Business Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="supplier_type" class="block text-sm font-medium text-gray-700">
                            Supplier Type <span class="text-red-500">*</span>
                        </label>
                        <select name="supplier_type" 
                                id="supplier_type" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            <option value="">Select Type</option>
                            <option value="Manufacturer" {{ old('supplier_type') == 'Manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                            <option value="Distributor" {{ old('supplier_type') == 'Distributor' ? 'selected' : '' }}>Distributor</option>
                            <option value="Wholesaler" {{ old('supplier_type') == 'Wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                            <option value="Retailer" {{ old('supplier_type') == 'Retailer' ? 'selected' : '' }}>Retailer</option>
                            <option value="Importer" {{ old('supplier_type') == 'Importer' ? 'selected' : '' }}>Importer</option>
                        </select>
                        @error('supplier_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_terms" class="block text-sm font-medium text-gray-700">
                            Payment Terms <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_terms" 
                                id="payment_terms" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            <option value="">Select Terms</option>
                            <option value="Cash" {{ old('payment_terms') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="15 Days" {{ old('payment_terms') == '15 Days' ? 'selected' : '' }}>15 Days</option>
                            <option value="30 Days" {{ old('payment_terms') == '30 Days' ? 'selected' : '' }}>30 Days</option>
                            <option value="45 Days" {{ old('payment_terms') == '45 Days' ? 'selected' : '' }}>45 Days</option>
                            <option value="60 Days" {{ old('payment_terms') == '60 Days' ? 'selected' : '' }}>60 Days</option>
                        </select>
                        @error('payment_terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        Notes
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Active Supplier</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('suppliers.index') }}" 
                       class="md-button md-button-secondary">
                        <i class="material-icons mr-2">cancel</i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="md-button md-button-primary">
                        <i class="material-icons mr-2">save</i>
                        Create Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

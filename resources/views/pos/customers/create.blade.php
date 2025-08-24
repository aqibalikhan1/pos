@extends('layouts.material-app')
@section('title', 'Create Customer')
@section('page-title', 'Add New Customer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Customer</h2>

            <form method="POST" action="{{ route('customers.store') }}" class="space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" id="address" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="town_id" class="block text-sm font-medium text-gray-700">Town</label>
                        <select name="town_id" id="town_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('town_id') border-red-500 @enderror">
                            <option value="">Select a town</option>
                            @foreach($towns as $town)
                                <option value="{{ $town->id }}" {{ old('town_id') == $town->id ? 'selected' : '' }}>
                                    {{ $town->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('town_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tax Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tax Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="is_filer" class="block text-sm font-medium text-gray-700">Tax Filer Status</label>
                            <select name="is_filer" id="is_filer" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('is_filer') border-red-500 @enderror">
                                <option value="1" {{ old('is_filer', 0) == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_filer', 0) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('is_filer')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Conditional fields for filers -->
                    <div id="filer-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6" style="display: none;">
                        <div>
                            <label for="cnic" class="block text-sm font-medium text-gray-700">CNIC Number *</label>
                            <input type="text" name="cnic" id="cnic" value="{{ old('cnic') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cnic') border-red-500 @enderror">
                            @error('cnic')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tax_number" class="block text-sm font-medium text-gray-700">Tax Number *</label>
                            <input type="text" name="tax_number" id="tax_number" value="{{ old('tax_number') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tax_number') border-red-500 @enderror">
                            @error('tax_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- JavaScript for conditional display -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const isFilerSelect = document.getElementById('is_filer');
                        const filerFields = document.getElementById('filer-fields');
                        const cnicInput = document.getElementById('cnic');
                        const taxNumberInput = document.getElementById('tax_number');

                        function toggleFilerFields() {
                            if (isFilerSelect.value === '1') {
                                filerFields.style.display = 'grid';
                                cnicInput.setAttribute('required', 'required');
                                taxNumberInput.setAttribute('required', 'required');
                            } else {
                                filerFields.style.display = 'none';
                                cnicInput.removeAttribute('required');
                                taxNumberInput.removeAttribute('required');
                                cnicInput.value = '';
                                taxNumberInput.value = '';
                            }
                        }

                        // Initial call
                        toggleFilerFields();

                        // Listen for changes
                        isFilerSelect.addEventListener('change', toggleFilerFields);
                    });
                </script>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.material-app')

@section('title', 'Create Supplier')
@section('page-title', 'Create Supplier')
@section('breadcrumb', 'Suppliers / Create')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/10 rounded-lg mr-4">
                    <i class="material-icons text-white text-2xl">add_circle</i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Create New Supplier</h2>
                    <p class="text-blue-100 text-sm">Set up a new supplier for your business operations</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential details about the supplier</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div class="space-y-2">
                            <label for="company_name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">business</i>
                                Company Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="company_name" 
                                       id="company_name" 
                                       value="{{ old('company_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('company_name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., ABC Suppliers Ltd."
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">business</i>
                                </div>
                            </div>
                            @error('company_name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Contact Name -->
                        <div class="space-y-2">
                            <label for="contact_name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">person</i>
                                Contact Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="contact_name" 
                                       id="contact_name" 
                                       value="{{ old('contact_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('contact_name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., John Doe"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">person</i>
                                </div>
                            </div>
                            @error('contact_name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">email</i>
                                Email Address
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., contact@abcsuppliers.com">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">email</i>
                                </div>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">phone</i>
                                Phone Number
                            </label>
                            <div class="relative">
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., +1 234-567-8900">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">phone</i>
                                </div>
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">location_on</i>
                            Address
                        </label>
                        <div class="relative">
                            <textarea name="address" 
                                      id="address" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('address') border-red-500 ring-red-200 @enderror"
                                      placeholder="Enter the supplier's complete address...">{{ old('address') }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-xs text-gray-400" id="address-count">0/500</span>
                            </div>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Configuration Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">settings</i>
                            Configuration
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Set up supplier type and status</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Supplier Type -->
                        <div class="space-y-2">
                            <label for="supplier_type" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">work</i>
                                Supplier Type
                            </label>
                            <div class="relative">
                                <select name="supplier_type" 
                                        id="supplier_type" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('supplier_type') border-red-500 ring-red-200 @enderror">
                                    <option value="" disabled>Select supplier type</option>
                                    <option value="wholesale" {{ old('supplier_type') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="retail" {{ old('supplier_type') == 'retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="manufacturer" {{ old('supplier_type') == 'manufacturer' ? 'selected' : '' }}>Manufacturer</option>
                                    <option value="distributor" {{ old('supplier_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                    <option value="service" {{ old('supplier_type') == 'service' ? 'selected' : '' }}>Service Provider</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('supplier_type')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="is_active" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">toggle_on</i>
                                Status
                            </label>
                            <div class="relative">
                                <select name="is_active" 
                                        id="is_active" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('is_active') border-red-500 ring-red-200 @enderror">
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('is_active')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <i class="material-icons text-sm align-middle mr-1">info</i>
                        Fields marked with * are required
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('suppliers.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Create Supplier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Character counter for address
        $('#address').on('input', function() {
            const length = $(this).val().length;
            $('#address-count').text(length + '/500');
        });

        // Initialize counter
        $('#address-count').text($('#address').val().length + '/500');
    });
</script>
@endpush

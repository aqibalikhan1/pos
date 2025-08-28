@extends('layouts.material-app')

@section('title', 'Create Tax Rate')
@section('page-title', 'Create Tax Rate')
@section('breadcrumb', 'Tax Rates / Create')

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
                    <h2 class="text-xl font-semibold text-white">Create New Tax Rate</h2>
                    <p class="text-blue-100 text-sm">Set up a new tax rate configuration for your products and services</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('settings.tax-rates.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential details about the tax rate</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tax Type -->
                        <div class="space-y-2">
                            <label for="tax_type_id" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">category</i>
                                Tax Type *
                            </label>
                            <div class="relative">
                                <select name="tax_type_id" 
                                        id="tax_type_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('tax_type_id') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="">Select Tax Type</option>
                                    @foreach($taxTypes as $taxType)
                                        <option value="{{ $taxType->id }}" {{ old('tax_type_id') == $taxType->id ? 'selected' : '' }}>
                                            {{ $taxType->name }} ({{ $taxType->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('tax_type_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">title</i>
                                Tax Rate Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., Standard VAT 15%"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">edit</i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Rate Configuration Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">percent</i>
                            Rate Configuration
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Set up the tax rate value and effective dates</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rate -->
                        <div class="space-y-2">
                            <label for="rate" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">trending_up</i>
                                Standard Rate (%) *
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="rate" 
                                       id="rate" 
                                       value="{{ old('rate') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('rate') border-red-500 ring-red-200 @enderror"
                                       placeholder="15.00"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">%</span>
                                </div>
                            </div>
                            @error('rate')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Filer Rate -->
                        <div class="space-y-2">
                            <label for="filer_rate" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">trending_down</i>
                                Filer Rate (%) 
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="filer_rate" 
                                       id="filer_rate" 
                                       value="{{ old('filer_rate') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('filer_rate') border-red-500 ring-red-200 @enderror"
                                       placeholder="10.00"
                                       step="0.01"
                                       min="0"
                                       max="100">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">%</span>
                                </div>
                            </div>
                            @error('filer_rate')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Effective Date -->
                        <div class="space-y-2">
                            <label for="effective_date" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">event</i>
                                Effective Date *
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="effective_date" 
                                       id="effective_date" 
                                       value="{{ old('effective_date', now()->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('effective_date') border-red-500 ring-red-200 @enderror"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">calendar_today</i>
                                </div>
                            </div>
                            @error('effective_date')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">event_busy</i>
                                End Date (Optional)
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date" 
                                       value="{{ old('end_date') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('end_date') border-red-500 ring-red-200 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">calendar_today</i>
                                </div>
                            </div>
                            @error('end_date')
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
                        <a href="{{ route('settings.tax-rates.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Create Tax Rate
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
        // Validate end date is after effective date
        $('#end_date').on('change', function() {
            const effectiveDate = new Date($('#effective_date').val());
            const endDate = new Date($(this).val());
            
            if (endDate <= effectiveDate) {
                alert('End date must be after effective date');
                $(this).val('');
            }
        });
    });
</script>
@endpush

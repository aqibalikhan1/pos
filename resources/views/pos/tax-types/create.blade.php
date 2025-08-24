@extends('layouts.material-app')

@section('title', 'Create Tax Type')
@section('page-title', 'Create Tax Type')
@section('breadcrumb', 'Tax Types / Create')

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
                    <h2 class="text-xl font-semibold text-white">Create New Tax Type</h2>
                    <p class="text-blue-100 text-sm">Set up a new tax configuration for your products and services</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('settings.tax-types.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential details about the tax type</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">title</i>
                                Tax Type Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., Value Added Tax, Sales Tax"
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

                        <!-- Code -->
                        <div class="space-y-2">
                            <label for="code" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">qr_code</i>
                                Short Code *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="code" 
                                       id="code" 
                                       value="{{ old('code') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('code') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., VAT15, STAX"
                                       maxlength="10"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <span class="text-xs text-gray-400" id="code-count">0/10</span>
                                </div>
                            </div>
                            @error('code')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">description</i>
                            Description
                        </label>
                        <div class="relative">
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 ring-red-200 @enderror"
                                      placeholder="Provide a brief description of this tax type and its usage...">{{ old('description') }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-xs text-gray-400" id="desc-count">0/500</span>
                            </div>
                        </div>
                        @error('description')
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
                        <p class="text-sm text-gray-600 mt-1">Set up the tax calculation method and status</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">category</i>
                                Calculation Type *
                            </label>
                            <div class="relative">
                                <select name="type" 
                                        id="type" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('type') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="" disabled>Select calculation type</option>
                                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('type')
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
                        <a href="{{ route('settings.tax-types.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Create Tax Type
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
        // Character counters
        $('#code').on('input', function() {
            const length = $(this).val().length;
            $('#code-count').text(length + '/10');
        });

        $('#description').on('input', function() {
            const length = $(this).val().length;
            $('#desc-count').text(length + '/500');
        });

        // Auto-generate code from name
        $('#name').on('blur', function() {
            const name = $(this).val();
            if (name && !$('#code').val()) {
                const code = name.toUpperCase().replace(/\s+/g, '').substring(0, 10);
                $('#code').val(code);
                $('#code-count').text(code.length + '/10');
            }
        });

        // Initialize counters
        $('#code-count').text($('#code').val().length + '/10');
        $('#desc-count').text($('#description').val().length + '/500');
    });
</script>
@endpush

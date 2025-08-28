@extends('layouts.material-app')

@section('title', 'Create Credit Note')
@section('page-title', 'Create Credit Note')
@section('breadcrumb', 'Credit Notes / Create')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/10 rounded-lg mr-4">
                    <i class="material-icons text-white text-2xl">receipt_long</i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Create New Credit Note</h2>
                    <p class="text-blue-100 text-sm">Set up a new credit note for your suppliers</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('credit-notes.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential details about the credit note</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Credit Note Number -->
                        <div class="space-y-2">
                            <label for="credit_note_number" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">receipt</i>
                                Credit Note Number *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="credit_note_number" 
                                       id="credit_note_number" 
                                       value="{{ old('credit_note_number') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('credit_note_number') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., CN-001"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">edit</i>
                                </div>
                            </div>
                            @error('credit_note_number')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div class="space-y-2">
                            <label for="supplier_id" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">person</i>
                                Supplier *
                            </label>
                            <div class="relative">
                                <select name="supplier_id" 
                                        id="supplier_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('supplier_id') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="" disabled>Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('supplier_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Account -->
                        <div class="space-y-2">
                            <label for="account_id" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">account_balance</i>
                                Account *
                            </label>
                            <div class="relative">
                                <select name="account_id" 
                                        id="account_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('account_id') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="" disabled>Select Account</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('account_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Credit Note Date -->
                        <div class="space-y-2">
                            <label for="credit_note_date" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">event</i>
                                Credit Note Date *
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="credit_note_date" 
                                       id="credit_note_date" 
                                       value="{{ old('credit_note_date') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('credit_note_date') border-red-500 ring-red-200 @enderror"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">calendar_today</i>
                                </div>
                            </div>
                            @error('credit_note_date')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Original Invoice Number -->
                        <div class="space-y-2">
                            <label for="original_invoice_number" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">description</i>
                                Original Invoice Number
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="original_invoice_number" 
                                       id="original_invoice_number" 
                                       value="{{ old('original_invoice_number') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('original_invoice_number') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., INV-001">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">edit</i>
                                </div>
                            </div>
                            @error('original_invoice_number')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">toggle_on</i>
                                Status *
                            </label>
                            <div class="relative">
                                <select name="status" 
                                        id="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">attach_money</i>
                                Amount *
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       value="{{ old('amount') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('amount') border-red-500 ring-red-200 @enderror"
                                       placeholder="0.00"
                                       step="0.01"
                                       min="0"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400">$</span>
                                </div>
                            </div>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">note</i>
                            Additional Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Additional details about the credit note</p>
                    </div>
                    
                    <!-- Reason -->
                    <div class="space-y-2">
                        <label for="reason" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">description</i>
                            Reason
                        </label>
                        <div class="relative">
                            <textarea name="reason" 
                                      id="reason" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('reason') border-red-500 ring-red-200 @enderror"
                                      placeholder="Provide a reason for this credit note...">{{ old('reason') }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-xs text-gray-400" id="reason-count">0/500</span>
                            </div>
                        </div>
                        @error('reason')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <i class="material-icons text-sm align-middle mr-1">info</i>
                        Fields marked with * are required
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('credit-notes.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Create Credit Note
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
        // Character counter for reason
        $('#reason').on('input', function() {
            const length = $(this).val().length;
            $('#reason-count').text(length + '/500');
        });

        // Initialize counter
        $('#reason-count').text($('#reason').val().length + '/500');
    });
</script>
@endpush

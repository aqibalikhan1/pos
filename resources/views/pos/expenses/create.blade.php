@extends('layouts.material-app')

@section('title', 'Add Expense')
@section('page-title', 'Add New Expense')
@section('breadcrumb', 'Expenses / Add')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">Add New Expense</h2>
                <a href="{{ route('expenses.index') }}" class="md-button md-button-secondary">
                    <i class="material-icons mr-2">arrow_back</i>
                    Back to List
                </a>
            </div>
        </div>
        
        <form action="{{ route('expenses.store') }}" method="POST" class="md-card-content space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="flex items-center">
                        <i class="material-icons mr-2">error</i>
                        <div>
                            <h3 class="font-medium">Please fix the following errors:</h3>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                    <select name="category_id" id="category_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('category_id') border-red-500 @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expense_date" class="block text-sm font-medium text-gray-700">Expense Date *</label>
                    <input type="date" name="expense_date" id="expense_date" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('expense_date') border-red-500 @enderror" 
                           value="{{ old('expense_date', date('Y-m-d')) }}" required>
                    @error('expense_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <input type="text" name="description" id="description" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('description') border-red-500 @enderror" 
                           value="{{ old('description') }}" required>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('amount') border-red-500 @enderror" 
                           value="{{ old('amount') }}" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="receipt_number" class="block text-sm font-medium text-gray-700">Receipt Number</label>
                    <input type="text" name="receipt_number" id="receipt_number" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('receipt_number') border-red-500 @enderror" 
                           value="{{ old('receipt_number') }}">
                    @error('receipt_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_recurring" id="is_recurring" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                           value="1" {{ old('is_recurring') ? 'checked' : '' }}>
                    <label for="is_recurring" class="ml-2 block text-sm text-gray-900">Recurring Expense</label>
                </div>
            </div>

            <div id="recurring_frequency_div" style="display: none;">
                <label for="recurring_frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                <select name="recurring_frequency" id="recurring_frequency" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('recurring_frequency') border-red-500 @enderror">
                    <option value="">Select Frequency</option>
                    <option value="daily" {{ old('recurring_frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ old('recurring_frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ old('recurring_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ old('recurring_frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
                @error('recurring_frequency')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('notes') border-red-500 @enderror"
                          placeholder="Optional notes for this expense">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('expenses.index') }}" 
                   class="md-button bg-gray-300 text-gray-700 hover:bg-gray-400">
                    <i class="material-icons mr-2">cancel</i>
                    Cancel
                </a>
                <button type="submit" class="md-button md-button-primary">
                    <i class="material-icons mr-2">save</i>
                    Save Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('is_recurring').addEventListener('change', function() {
        const recurringDiv = document.getElementById('recurring_frequency_div');
        const recurringSelect = document.getElementById('recurring_frequency');
        
        if (this.checked) {
            recurringDiv.style.display = 'block';
            recurringSelect.required = true;
        } else {
            recurringDiv.style.display = 'none';
            recurringSelect.required = false;
            recurringSelect.value = '';
        }
    });

    // Trigger on page load if checkbox was previously checked
    if (document.getElementById('is_recurring').checked) {
        document.getElementById('recurring_frequency_div').style.display = 'block';
    }
</script>
@endpush

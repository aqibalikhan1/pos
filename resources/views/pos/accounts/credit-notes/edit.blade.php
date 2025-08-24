@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Credit Note Received</h1>

        <form action="{{ route('credit-notes.update', $creditNote) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_note_number">
                    Credit Note Number *
                </label>
                <input type="text" 
                       name="credit_note_number" 
                       id="credit_note_number" 
                       value="{{ old('credit_note_number', $creditNote->credit_note_number) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('credit_note_number') border-red-500 @enderror"
                       required>
                @error('credit_note_number')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="supplier_id">
                    Supplier *
                </label>
                <select name="supplier_id" 
                        id="supplier_id" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('supplier_id') border-red-500 @enderror"
                        required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $creditNote->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="account_id">
                    Account *
                </label>
                <select name="account_id" 
                        id="account_id" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('account_id') border-red-500 @enderror"
                        required>
                    <option value="">Select Account</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('account_id', $creditNote->account_id) == $account->id ? 'selected' : '' }}>
                            {{ $account->account_name }} ({{ $account->account_number }})
                        </option>
                    @endforeach
                </select>
                @error('account_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_note_date">
                        Credit Note Date *
                    </label>
                    <input type="date" 
                           name="credit_note_date" 
                           id="credit_note_date" 
                           value="{{ old('credit_note_date', $creditNote->credit_note_date->format('Y-m-d')) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('credit_note_date') border-red-500 @enderror"
                           required>
                    @error('credit_note_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="original_purchase_date">
                        Original Purchase Date
                    </label>
                    <input type="date" 
                           name="original_purchase_date" 
                           id="original_purchase_date" 
                           value="{{ old('original_purchase_date', optional($creditNote->original_purchase_date)->format('Y-m-d')) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('original_purchase_date') border-red-500 @enderror">
                    @error('original_purchase_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="original_invoice_number">
                    Original Invoice Number
                </label>
                <input type="text" 
                       name="original_invoice_number" 
                       id="original_invoice_number" 
                       value="{{ old('original_invoice_number', $creditNote->original_invoice_number) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('original_invoice_number') border-red-500 @enderror">
                @error('original_invoice_number')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="subtotal">
                        Subtotal *
                    </label>
                    <input type="number" 
                           name="subtotal" 
                           id="subtotal" 
                           step="0.01"
                           value="{{ old('subtotal', $creditNote->subtotal) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('subtotal') border-red-500 @enderror"
                           required>
                    @error('subtotal')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tax_amount">
                        Tax Amount
                    </label>
                    <input type="number" 
                           name="tax_amount" 
                           id="tax_amount" 
                           step="0.01"
                           value="{{ old('tax_amount', $creditNote->tax_amount) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tax_amount') border-red-500 @enderror">
                    @error('tax_amount')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="discount_amount">
                        Discount Amount
                    </label>
                    <input type="number" 
                           name="discount_amount" 
                           id="discount_amount" 
                           step="0.01"
                           value="{{ old('discount_amount', $creditNote->discount_amount) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('discount_amount') border-red-500 @enderror">
                    @error('discount_amount')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="total_amount">
                    Total Amount *
                </label>
                <input type="number" 
                       name="total_amount" 
                       id="total_amount" 
                       step="0.01"
                       value="{{ old('total_amount', $creditNote->total_amount) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('total_amount') border-red-500 @enderror"
                       required>
                @error('total_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                    Reason
                </label>
                <textarea name="reason" 
                          id="reason" 
                          rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reason') border-red-500 @enderror">{{ old('reason', $creditNote->reason) }}</textarea>
                @error('reason')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status *
                </label>
                <select name="status" 
                        id="status" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                        required>
                    <option value="pending" {{ old('status', $creditNote->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $creditNote->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status', $creditNote->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Credit Note
                </button>
                <a href="{{ route('credit-notes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('subtotal').addEventListener('input', calculateTotal);
document.getElementById('tax_amount').addEventListener('input', calculateTotal);
document.getElementById('discount_amount').addEventListener('input', calculateTotal);

function calculateTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    
    const total = subtotal + tax - discount;
    document.getElementById('total_amount').value = total.toFixed(2);
}
</script>
@endsection

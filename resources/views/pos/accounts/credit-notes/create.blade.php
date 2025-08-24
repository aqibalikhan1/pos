@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Credit Note Received</h1>

        <form action="{{ route('credit-notes.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_note_number">
                    Credit Note Number *
                </label>
                <input type="text" 
                       name="credit_note_number" 
                       id="credit_note_number" 
                       value="{{ old('credit_note_number', 'CN-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('credit_note_number') border-red-500 @enderror"
                       required>
                @error('credit_note_number')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_id">
                    Customer *
                </label>
                <select name="customer_id" 
                        id="customer_id" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('customer_id') border-red-500 @enderror"
                        required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} - {{ $customer->phone }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
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
                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->account_name }} ({{ $account->account_number }})
                        </option>
                    @endforeach
                </select>
                @error('account_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_note_date">
                    Credit Note Date *
                </label>
                <input type="date" 
                       name="credit_note_date" 
                       id="credit_note_date" 
                       value="{{ old('credit_note_date', date('Y-m-d')) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('credit_note_date') border-red-500 @enderror"
                       required>
                @error('credit_note_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="original_sale_date">
                    Original Sale Date
                </label>
                <input type="date" 
                       name="original_sale_date" 
                       id="original_sale_date" 
                       value="{{ old('original_sale_date') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('original_sale_date') border-red-500 @enderror">
                @error('original_sale_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="original_invoice_number">
                    Original Invoice Number
                </label>
                <input type="text" 
                       name="original_invoice_number" 
                       id="original_invoice_number" 
                       value="{{ old('original_invoice_number') }}"
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
                           value="{{ old('subtotal', 0) }}"
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
                           value="{{ old('tax_amount', 0) }}"
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
                           value="{{ old('discount_amount', 0) }}"
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
                       value="{{ old('total_amount', 0) }}"
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
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reason') border-red-500 @enderror">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Credit Note
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

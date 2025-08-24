@extends('layouts.material-app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Sale Invoice #{{ $saleInvoice->invoice_number }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('sale-invoices.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to List
            </a>
            @if($saleInvoice->payment_status !== 'paid')
                <a href="{{ route('sale-invoices.edit', $saleInvoice) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit
                </a>
            @endif
            <a href="{{ route('sale-invoices.print', $saleInvoice) }}" target="_blank" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Print
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Invoice Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Invoice Details</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Invoice Number:</p>
                        <p class="text-lg font-semibold">{{ $saleInvoice->invoice_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Sale Date:</p>
                        <p>{{ $saleInvoice->sale_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Employee:</p>
                        <p>{{ $saleInvoice->employee->first_name }} {{ $saleInvoice->employee->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Customer:</p>
                        <p>{{ $saleInvoice->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Sale Type:</p>
                        <p class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $saleInvoice->sale_type === 'cash' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($saleInvoice->sale_type) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Payment Status:</p>
                        <p class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $saleInvoice->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                  ($saleInvoice->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($saleInvoice->payment_status) }}
                        </p>
                    </div>
                </div>

                @if($saleInvoice->notes)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Notes:</p>
                        <p class="text-gray-600">{{ $saleInvoice->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Invoice Items -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4">Invoice Items</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($saleInvoice->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($item->quantity, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->discount_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->tax_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($item->total_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Summary</h2>
                
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                        <span>${{ number_format($saleInvoice->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Discount:</span>
                        <span>-${{ number_format($saleInvoice->discount_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Tax:</span>
                        <span>+${{ number_format($saleInvoice->tax_amount, 2) }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold">
                        <span class="text-sm font-medium text-gray-700">Total:</span>
                        <span>${{ number_format($saleInvoice->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Paid:</span>
                        <span>${{ number_format($saleInvoice->paid_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Due:</span>
                        <span>${{ number_format($saleInvoice->due_amount, 2) }}</span>
                    </div>
                </div>

                @if($saleInvoice->due_date)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Due Date:</p>
                        <p>{{ $saleInvoice->due_date->format('M d, Y') }}</p>
                    </div>
                @endif
            </div>

            <!-- Account Transactions -->
            @if($saleInvoice->accountTransactions->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-lg font-semibold mb-4">Account Transactions</h2>
                    
                    <div class="space-y-2">
                        @foreach($saleInvoice->accountTransactions as $transaction)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium">{{ $transaction->account->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->transaction_date->format('M d, Y') }}</p>
                                </div>
                                <span class="text-sm font-semibold text-green-600">
                                    +${{ number_format($transaction->amount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

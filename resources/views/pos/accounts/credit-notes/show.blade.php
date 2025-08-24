@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Credit Note Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('credit-notes.edit', $creditNote) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('credit-notes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Credit Note Information</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="font-medium text-gray-600">Credit Note Number:</span>
                                <span class="ml-2">{{ $creditNote->credit_note_number }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Customer:</span>
                                <span class="ml-2">{{ $creditNote->customer->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Account:</span>
                                <span class="ml-2">{{ $creditNote->account->account_name }} ({{ $creditNote->account->account_number }})</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Date:</span>
                                <span class="ml-2">{{ $creditNote->credit_note_date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Status:</span>
                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    bg-{{ $creditNote->status_color }}-100 text-{{ $creditNote->status_color }}-800">
                                    {{ ucfirst($creditNote->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Original Sale Details</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="font-medium text-gray-600">Original Sale Date:</span>
                                <span class="ml-2">{{ optional($creditNote->original_sale_date)->format('d/m/Y') ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Original Invoice:</span>
                                <span class="ml-2">{{ $creditNote->original_invoice_number ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Amount Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Subtotal:</span>
                                <span>${{ number_format($creditNote->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Tax Amount:</span>
                                <span>${{ number_format($creditNote->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Discount Amount:</span>
                                <span>${{ number_format($creditNote->discount_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="font-bold text-gray-800">Total Amount:</span>
                                <span class="font-bold text-gray-800">${{ number_format($creditNote->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($creditNote->reason)
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Reason</h3>
                    <p class="text-gray-600">{{ $creditNote->reason }}</p>
                </div>
                @endif

                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Additional Information</h3>
                    <div class="text-sm text-gray-500">
                        <p>Created by: {{ $creditNote->creator->name }} on {{ $creditNote->created_at->format('d/m/Y H:i') }}</p>
                        <p>Last updated: {{ $creditNote->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

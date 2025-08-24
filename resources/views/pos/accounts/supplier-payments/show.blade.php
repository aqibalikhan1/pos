@extends('layouts.material-app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Supplier Payment Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('accounts.supplier-payments.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="material-icons text-sm mr-1">arrow_back</i>
                    Back to List
                </a>
                <a href="{{ route('accounts.supplier-payments.edit', $supplierPayment) }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    <i class="material-icons text-sm mr-1">edit</i>
                    Edit
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Payment Information</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Basic Details</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Payment Number:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->payment_number }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Supplier:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->supplier->company_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Payment Date:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->payment_date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Amount:</span>
                                <span class="ml-2 text-gray-900 font-semibold">Rs {{ number_format($supplierPayment->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment Details</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Payment Method:</span>
                                <span class="ml-2 text-gray-900">{{ ucfirst(str_replace('_', ' ', $supplierPayment->payment_method)) }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Reference Number:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->reference_number ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Created By:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->creator->name ?? 'System' }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Created At:</span>
                                <span class="ml-2 text-gray-900">{{ $supplierPayment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($supplierPayment->purchase)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Related Purchase</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Purchase ID:</span>
                                <span class="ml-2 text-gray-900">PUR-{{ $supplierPayment->purchase->id }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Total Amount:</span>
                                <span class="ml-2 text-gray-900">Rs {{ number_format($supplierPayment->purchase->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($supplierPayment->notes)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Notes</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-700">{{ $supplierPayment->notes }}</p>
                    </div>
                </div>
                @endif

                <div class="mt-8 flex justify-between items-center">
                    <div>
                        <span class="text-sm text-gray-600">Last updated: {{ $supplierPayment->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex space-x-3">
                        <form action="{{ route('accounts.supplier-payments.destroy', $supplierPayment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                <i class="material-icons text-sm mr-1">delete</i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

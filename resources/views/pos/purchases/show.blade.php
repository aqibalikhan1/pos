@extends('layouts.material-app')

@section('title', 'Purchase Details')
@section('page-title', 'Purchase Order Details')
@section('breadcrumb', 'Purchase Details')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Purchase Header -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="md-card-title">Purchase Order #{{ $purchase->purchase_number }}</h2>
                    <p class="text-sm text-gray-500">Created by {{ $purchase->creator->name ?? 'System' }} on {{ $purchase->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="flex space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $purchase->status_color }}-100 text-{{ $purchase->status_color }}-800">
                        {{ ucfirst(str_replace('_', ' ', $purchase->status)) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $purchase->payment_status_color }}-100 text-{{ $purchase->payment_status_color }}-800">
                        {{ ucfirst($purchase->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Supplier Information</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm text-gray-600">Name:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->supplier->company_name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->supplier->email ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Phone:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->supplier->phone ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Address:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->supplier->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Order Details</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm text-gray-600">Purchase Date:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->purchase_date->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Expected Delivery:</span>
                            <span class="text-sm font-medium ml-2">{{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        @if($purchase->notes)
                        <div>
                            <span class="text-sm text-gray-600">Notes:</span>
                            <p class="text-sm font-medium mt-1">{{ $purchase->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Order Items ({{ $purchase->items->count() }})</h2>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($purchase->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->quantity }} {{ $item->product->unit ?? 'units' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ config('currency.symbol') }}{{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($item->discount_percent > 0)
                                    {{ $item->discount_percent }}% ({{ config('currency.symbol') }}{{ number_format($item->discount_amount, 2) }})
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                             @if($item->tax_percent > 0)
                                    {{ $item->tax_percent }}% ({{ config('currency.symbol') }}{{ number_format($item->tax_amount, 2) }})
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ config('currency.symbol') }}{{ number_format($item->net_amount, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Subtotal:</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ config('currency.symbol') }}{{ number_format($purchase->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Discount:</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ config('currency.symbol') }}{{ number_format($purchase->discount_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Tax:</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ config('currency.symbol') }}{{ number_format($purchase->tax_amount, 2) }}</td>
                        </tr>
                        <tr class="border-t-2">
                            <td colspan="5" class="px-6 py-4 text-right text-lg font-bold text-gray-900">Total:</td>
                            <td class="px-6 py-4 text-lg font-bold text-green-600">{{ config('currency.symbol') }}{{ number_format($purchase->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-3">
        <a href="{{ route('purchases.index') }}" class="md-button md-button-secondary">
            <i class="material-icons mr-2">arrow_back</i>
            Back to List
        </a>
        
        @if($purchase->status === 'pending')
        <a href="{{ route('purchases.edit', $purchase->id) }}" class="md-button md-button-primary">
            <i class="material-icons mr-2">edit</i>
            Edit
        </a>
        
        <form action="{{ route('purchases.receive', $purchase->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="md-button md-button-success" 
                    onclick="return confirm('Are you sure you want to mark this purchase as received? This will update stock levels.')">
                <i class="material-icons mr-2">inventory</i>
                Mark as Received
            </button>
        </form>
        @endif
        
        <button onclick="window.print()" class="md-button md-button-secondary">
            <i class="material-icons mr-2">print</i>
            Print
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Print functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                body * {
                    visibility: hidden;
                }
                .md-card, .md-card * {
                    visibility: visible;
                }
                .md-card {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

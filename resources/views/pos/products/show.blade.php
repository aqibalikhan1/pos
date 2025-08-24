@extends('layouts.material-app')

@section('title', 'Products')
@section('page-title', 'Products Show')
@section('breadcrumb', 'Products')


@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Product Details</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            <i class="material-icons mr-2">edit</i>
                            Edit
                        </a>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">SKU</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->sku }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->description ?? 'No description available' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->category ? $product->category->name : 'No category assigned' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->company ? $product->company->name : 'No company assigned' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Barcode</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->barcode ?? 'No barcode' }}</p>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pricing & Stock</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \App\Helpers\CurrencyHelper::formatAmount($product->price) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cost Price</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \App\Helpers\CurrencyHelper::formatAmount($product->cost_price ?? 0) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->stock_quantity }} {{ $product->unit }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minimum Stock Level</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->min_stock_level }} {{ $product->unit }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Packaging Information -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Packaging Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Packaging Type</label>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($product->packaging_type) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pieces per Pack</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->pieces_per_pack }} pieces</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Total Packs</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ceil($product->stock_quantity / $product->pieces_per_pack) }} {{ ucfirst($product->packaging_type) }}(s)</p>
                    </div>
                </div>

                <!-- Tax Rates Information -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tax Rates</h3>
                    
                    @if($product->taxRates->count() > 0)
                        <div class="bg-gray-50 rounded-md p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($product->taxRates as $taxRate)
                                    <div class="bg-white rounded-md p-3 shadow-sm border border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-700">{{ $taxRate->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $taxRate->rate }}%</span>
                                        </div>
                                        @if($taxRate->taxType)
                                            <p class="text-xs text-gray-500 mt-1">{{ $taxRate->taxType->name }}</p>
                                        @endif
                                        <p class="text-xs text-blue-600 mt-1">
                                            Applies to: 
                                            @php
                                                $transactionType = $taxRate->pivot->transaction_type ?? 'both';
                                                $transactionLabel = match($transactionType) {
                                                    'sale' => 'Sales Only',
                                                    'purchase' => 'Purchases Only',
                                                    default => 'Both Sales & Purchases'
                                                };
                                            @endphp
                                            {{ $transactionLabel }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <i class="material-icons text-yellow-400 mr-3">info</i>
                                <div>
                                    <h3 class="text-sm font-medium text-yellow-800">No Tax Rates Assigned</h3>
                                    <p class="mt-1 text-sm text-yellow-700">
                                        This product doesn't have any tax rates assigned. You can assign tax rates in the edit form.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Stock Alert -->
                <div class="mt-6">
                    @if($product->stock_quantity <= $product->min_stock_level)
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <i class="material-icons text-red-400 mr-3">warning</i>
                                <div>
                                    <h3 class="text-sm font-medium text-red-800">Low Stock Alert</h3>
                                    <p class="mt-1 text-sm text-red-700">
                                        This product has low stock. Consider restocking soon.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex">
                                <i class="material-icons text-green-400 mr-3">check_circle</i>
                                <div>
                                    <h3 class="text-sm font-medium text-green-800">Stock Status</h3>
                                    <p class="mt-1 text-sm text-green-700">
                                        Stock level is adequate.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

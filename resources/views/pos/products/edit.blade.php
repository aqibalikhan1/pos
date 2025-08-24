@extends('layouts.material-app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('breadcrumb', 'Products / Edit')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">inventory_2</i>
            </div>
            <div class="stats-card-title">Product Name</div>
            <div class="stats-card-value">{{ $product->name }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="stats-card-title">Price</div>
            <div class="stats-card-value">${{ number_format($product->price, 2) }}</div>
        </div>

        <div class="stats-card">
            <div class="stats-card-icon bg-orange-100 text-orange-600">
                <i class="material-icons">inventory</i>
            </div>
            <div class="stats-card-title">Stock Quantity</div>
            <div class="stats-card-value">{{ $product->stock_quantity }}</div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/10 rounded-lg mr-4">
                    <i class="material-icons text-white text-2xl">edit</i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Edit Product</h2>
                    <p class="text-blue-100 text-sm">Update product details for your inventory management</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential product details</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">title</i>
                                Product Name *
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                                       placeholder="Enter product name">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">inventory_2</i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="space-y-2">
                            <label for="sku" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">qr_code</i>
                                SKU *
                            </label>
                            <div class="relative">
                                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('sku') border-red-500 ring-red-200 @enderror"
                                       placeholder="Enter SKU code">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">tag</i>
                                </div>
                            </div>
                            @error('sku')
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
                            <textarea name="description" id="description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 ring-red-200 @enderror"
                                      placeholder="Product description">{{ old('description', $product->description) }}</textarea>
                            <div class="absolute top-3 right-3 flex items-center pointer-events-none">
                                <i class="material-icons text-gray-400 text-sm">notes</i>
                            </div>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Company -->
                        <div class="space-y-2">
                            <label for="company_id" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">business</i>
                                Company *
                            </label>
                            <div class="relative">
                                <select name="company_id" id="company_id" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('company_id') border-red-500 ring-red-200 @enderror">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('company_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">category</i>
                                Category *
                            </label>
                            <div class="relative">
                                <select name="category_id" id="category_id" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('category_id') border-red-500 ring-red-200 @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <label for="price" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">attach_money</i>
                                Price *
                            </label>
                            <div class="relative">
                                <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price) }}" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('price') border-red-500 ring-red-200 @enderror"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400">$</span>
                                </div>
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">trending_up</i>
                            Pricing & Stock Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Financial and inventory details</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Cost Price -->
                        <div class="space-y-2">
                            <label for="cost_price" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">paid</i>
                                Cost Price
                            </label>
                            <div class="relative">
                                <input type="number" name="cost_price" id="cost_price" step="0.01" value="{{ old('cost_price', $product->cost_price) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('cost_price') border-red-500 ring-red-200 @enderror"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400">$</span>
                                </div>
                            </div>
                            @error('cost_price')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="space-y-2">
                            <label for="stock_quantity" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">inventory</i>
                                Stock Quantity *
                            </label>
                            <div class="relative">
                                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('stock_quantity') border-red-500 ring-red-200 @enderror"
                                       placeholder="0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">numbers</i>
                                </div>
                            </div>
                            @error('stock_quantity')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Minimum Stock Level -->
                        <div class="space-y-2">
                            <label for="min_stock_level" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">warning</i>
                                Minimum Stock Level
                            </label>
                            <div class="relative">
                                <input type="number" name="min_stock_level" id="min_stock_level" value="{{ old('min_stock_level', $product->min_stock_level) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('min_stock_level') border-red-500 ring-red-200 @enderror"
                                       placeholder="0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">low_priority</i>
                                </div>
                            </div>
                            @error('min_stock_level')
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
                            <i class="material-icons text-blue-600 mr-2">settings</i>
                            Additional Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Product specifications and status</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Unit -->
                        <div class="space-y-2">
                            <label for="unit" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">straighten</i>
                                Unit *
                            </label>
                            <div class="relative">
                                <select name="unit" id="unit" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('unit') border-red-500 ring-red-200 @enderror">
                                    <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                    <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="g" {{ old('unit', $product->unit) == 'g' ? 'selected' : '' }}>Gram (g)</option>
                                    <option value="ltr" {{ old('unit', $product->unit) == 'ltr' ? 'selected' : '' }}>Liter (ltr)</option>
                                    <option value="ml" {{ old('unit', $product->unit) == 'ml' ? 'selected' : '' }}>Milliliter (ml)</option>
                                    <option value="box" {{ old('unit', $product->unit) == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('unit')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Barcode -->
                        <div class="space-y-2">
                            <label for="barcode" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">qr_code_scanner</i>
                                Barcode
                            </label>
                            <div class="relative">
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('barcode') border-red-500 ring-red-200 @enderror"
                                       placeholder="Enter barcode">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">scanner</i>
                                </div>
                            </div>
                            @error('barcode')
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
                                <select name="is_active" id="is_active" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('is_active') border-red-500 ring-red-200 @enderror">
                                    <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
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

                <!-- Tax Rates Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">receipt</i>
                            Tax Rates
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Select applicable tax rates for this product and specify transaction types</p>
                    </div>
                    
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">percent</i>
                            Applicable Tax Rates
                        </label>
                        
                        <div class="space-y-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($taxRates as $taxRate)
                                @php
                                    $currentTaxRate = $product->taxRates->find($taxRate->id);
                                    $transactionType = $currentTaxRate ? $currentTaxRate->pivot->transaction_type : 'both';
                                    $isChecked = in_array($taxRate->id, old('tax_rates', $product->taxRates->pluck('id')->toArray()));
                                @endphp
                                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" 
                                               name="tax_rates[]" 
                                               id="tax_rate_{{ $taxRate->id }}"
                                               value="{{ $taxRate->id }}"
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="tax_rate_{{ $taxRate->id }}" class="text-sm font-medium text-gray-700">
                                            {{ $taxRate->name }} ({{ $taxRate->rate }}%)
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <label class="text-xs text-gray-600">Apply to:</label>
                                        <select name="tax_rate_types[{{ $taxRate->id }}]" 
                                                class="text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                            <option value="both" {{ old('tax_rate_types.' . $taxRate->id, $transactionType) == 'both' ? 'selected' : '' }}>Both</option>
                                            <option value="sale" {{ old('tax_rate_types.' . $taxRate->id, $transactionType) == 'sale' ? 'selected' : '' }}>Sales Only</option>
                                            <option value="purchase" {{ old('tax_rate_types.' . $taxRate->id, $transactionType) == 'purchase' ? 'selected' : '' }}>Purchases Only</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <p class="text-xs text-gray-500">Select tax rates and specify whether they apply to sales, purchases, or both</p>
                        @error('tax_rates')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Packaging Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">inventory</i>
                            Packaging Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Product packaging details</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Packaging Type -->
                        <div class="space-y-2">
                            <label for="packaging_type" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">package</i>
                                Packaging Type *
                            </label>
                            <div class="relative">
                                <select name="packaging_type" id="packaging_type" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('packaging_type') border-red-500 ring-red-200 @enderror">
                                    <option value="carton" {{ old('packaging_type', $product->packaging_type) == 'carton' ? 'selected' : '' }}>Carton</option>
                                    <option value="box" {{ old('packaging_type', $product->packaging_type) == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="bag" {{ old('packaging_type', $product->packaging_type) == 'bag' ? 'selected' : '' }}>Bag</option>
                                    <option value="bottle" {{ old('packaging_type', $product->packaging_type) == 'bottle' ? 'selected' : '' }}>Bottle</option>
                                    <option value="jar" {{ old('packaging_type', $product->packaging_type) == 'jar' ? 'selected' : '' }}>Jar</option>
                                    <option value="packet" {{ old('packaging_type', $product->packaging_type) == 'packet' ? 'selected' : '' }}>Packet</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('packaging_type')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Pieces per Pack -->
                        <div class="space-y-2">
                            <label for="pieces_per_pack" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">layers</i>
                                Pieces per Pack *
                            </label>
                            <div class="relative">
                                <input type="number" name="pieces_per_pack" id="pieces_per_pack" value="{{ old('pieces_per_pack', $product->pieces_per_pack) }}" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('pieces_per_pack') border-red-500 ring-red-200 @enderror"
                                       placeholder="1">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">numbers</i>
                                </div>
                            </div>
                            @error('pieces_per_pack')
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
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

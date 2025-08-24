@extends('layouts.material-app')

@section('title', 'Tax Configuration')
@section('page-title', 'Tax Configuration')
@section('breadcrumb', 'Tax Configuration')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">receipt</i>
            </div>
            <div class="stats-card-title">Total Tax Types</div>
            <div class="stats-card-value">{{ \App\Models\TaxType::count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">percent</i>
            </div>
            <div class="stats-card-title">Total Tax Rates</div>
            <div class="stats-card-value">{{ \App\Models\TaxRate::count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">inventory</i>
            </div>
            <div class="stats-card-title">Products with Tax</div>
            <div class="stats-card-value">{{ \App\Models\ProductTaxMapping::distinct('product_id')->count() }}</div>
        </div>
    </div>

    <!-- Tax Management Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tax Types Card -->
        <div class="md-card">
            <div class="md-card-header">
                <div class="flex justify-between items-center">
                    <h2 class="md-card-title">Tax Types</h2>
                    <a href="{{ route('settings.tax-types.index') }}" class="md-button md-button-secondary">
                        <i class="material-icons mr-2">list</i>
                        View All
                    </a>
                </div>
            </div>
            
            <div class="md-card-content">
                <p class="text-gray-600 mb-4">Manage different types of taxes (percentage, fixed amount, etc.) that can be applied to products and services.</p>
                
                <div class="space-y-3">
                    @php
                        $recentTaxTypes = \App\Models\TaxType::latest()->take(3)->get();
                    @endphp
                    
                    @forelse($recentTaxTypes as $taxType)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mr-3">
                                <i class="material-icons text-purple-600 text-xs">{{ substr($taxType->name, 0, 1) }}</i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $taxType->name }}</div>
                                <div class="text-xs text-gray-500">{{ $taxType->code }}</div>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                            {{ $taxType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $taxType->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="material-icons text-gray-300 text-4xl mb-2">receipt</i>
                        <p class="text-gray-500 text-sm">No tax types found</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('settings.tax-types.create') }}" class="md-button md-button-primary flex-1">
                        <i class="material-icons mr-2">add</i>
                        Add Tax Type
                    </a>
                </div>
            </div>
        </div>

        <!-- Tax Rates Card -->
        <div class="md-card">
            <div class="md-card-header">
                <div class="flex justify-between items-center">
                    <h2 class="md-card-title">Tax Rates</h2>
                    <a href="{{ route('settings.tax-rates.index') }}" class="md-button md-button-secondary">
                        <i class="material-icons mr-2">list</i>
                        View All
                    </a>
                </div>
            </div>
            
            <div class="md-card-content">
                <p class="text-gray-600 mb-4">Manage specific tax rates and their application rules for different tax types.</p>
                
                <div class="space-y-3">
                    @php
                        $recentTaxRates = \App\Models\TaxRate::with('taxType')->latest()->take(3)->get();
                    @endphp
                    
                    @forelse($recentTaxRates as $taxRate)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center mr-3">
                                <i class="material-icons text-blue-600 text-xs">percent</i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $taxRate->name }}</div>
                                <div class="text-xs text-gray-500">{{ $taxRate->taxType->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $taxRate->rate }}{{ $taxRate->taxType->type == 'percentage' ? '%' : '' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="material-icons text-gray-300 text-4xl mb-2">percent</i>
                        <p class="text-gray-500 text-sm">No tax rates found</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('settings.tax-rates.create') }}" class="md-button md-button-primary flex-1">
                        <i class="material-icons mr-2">add</i>
                        Add Tax Rate
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Quick Actions</h2>
        </div>
        
        <div class="md-card-content">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('settings.tax-types.index') }}" class="quick-action-card">
                    <div class="quick-action-icon bg-purple-100 text-purple-600">
                        <i class="material-icons">receipt</i>
                    </div>
                    <div class="quick-action-title">Manage Tax Types</div>
                    <div class="quick-action-description">View and manage all tax types</div>
                </a>
                
                <a href="{{ route('settings.tax-rates.index') }}" class="quick-action-card">
                    <div class="quick-action-icon bg-blue-100 text-blue-600">
                        <i class="material-icons">percent</i>
                    </div>
                    <div class="quick-action-title">Manage Tax Rates</div>
                    <div class="quick-action-description">View and manage all tax rates</div>
                </a>
                
                <a href="{{ route('products.index') }}" class="quick-action-card">
                    <div class="quick-action-icon bg-green-100 text-green-600">
                        <i class="material-icons">inventory</i>
                    </div>
                    <div class="quick-action-title">Product Tax Mapping</div>
                    <div class="quick-action-description">Assign taxes to products</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Documentation Card -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Tax Configuration Guide</h2>
        </div>
        
        <div class="md-card-content">
            <div class="prose prose-sm max-w-none">
                <h3 class="text-lg font-medium text-gray-900 mb-3">How to Set Up Taxes</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">1. Create Tax Types</h4>
                        <p class="text-gray-600 text-sm mb-4">
                            Define different types of taxes like VAT, GST, Sales Tax, etc. Each type can have different calculation methods (percentage or fixed amount).
                        </p>
                        
                        <h4 class="font-medium text-gray-800 mb-2">2. Set Up Tax Rates</h4>
                        <p class="text-gray-600 text-sm mb-4">
                            Create specific rates for each tax type. For example, VAT at 15%, GST at 18%, etc. You can have multiple rates for the same tax type.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">3. Assign to Products</h4>
                        <p class="text-gray-600 text-sm mb-4">
                            Assign appropriate tax rates to your products. Products can have multiple tax rates applied to them.
                        </p>
                        
                        <h4 class="font-medium text-gray-800 mb-2">4. Review Settings</h4>
                        <p class="text-gray-600 text-sm">
                            Regularly review your tax settings to ensure compliance with current tax regulations and rates.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.quick-action-card {
    @apply block p-4 bg-white border border-gray-200 rounded-lg hover:border-purple-300 hover:shadow-md transition-all duration-200;
}

.quick-action-icon {
    @apply w-12 h-12 rounded-full flex items-center justify-center mb-3;
}

.quick-action-title {
    @apply text-sm font-medium text-gray-900 mb-1;
}

.quick-action-description {
    @apply text-xs text-gray-500;
}

.stats-card {
    @apply bg-white p-4 rounded-lg border border-gray-200;
}

.stats-card-icon {
    @apply w-12 h-12 rounded-full flex items-center justify-center mb-3;
}

.stats-card-title {
    @apply text-sm text-gray-600 mb-1;
}

.stats-card-value {
    @apply text-2xl font-bold text-gray-900;
}
</style>
@endpush

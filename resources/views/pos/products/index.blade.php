  @extends('layouts.material-app')

@section('title', 'Products')
@section('page-title', 'Products Management')
@section('breadcrumb', 'Products')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">inventory</i>
            </div>
            <div class="stats-card-title">Total Products</div>
            <div class="stats-card-value">{{ $products->count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-yellow-100 text-yellow-600">
                <i class="material-icons">warning</i>
            </div>
            <div class="stats-card-title">Low Stock</div>
            <div class="stats-card-value">{{ $lowStockCount ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="stats-card-title">Total Value</div>
            <div class="stats-card-value">{{ \App\Helpers\CurrencyHelper::formatAmount($totalValue ?? 0) }}</div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">All Products</h2>
                <a href="{{ route('products.create') }}" class="md-button md-button-primary">
                    <i class="material-icons mr-2">add</i>
                    Add Product
                </a>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 data-table" id="productsTable">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">image</i>
                                    Image
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">inventory_2</i>
                                    Product
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">qr_code</i>
                                    SKU
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">category</i>
                                    Category
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">business</i>
                                    Company
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">shopping_cart</i>
                                    Purchase
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">store</i>
                                    Trade
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">print</i>
                                    Print
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">local_shipping</i>
                                    Wholesale
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">inventory</i>
                                    Stock
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">inventory_2</i>
                                    Packaging
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">settings</i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="material-icons text-gray-400 text-lg">inventory_2</i>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->sku }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ ucfirst($product->category->name ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $product->company->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-blue-600">{{ \App\Helpers\CurrencyHelper::formatAmount($product->purchase_price) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-green-600">{{ \App\Helpers\CurrencyHelper::formatAmount($product->trade_price) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-purple-600">{{ \App\Helpers\CurrencyHelper::formatAmount($product->print_price) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-orange-600">{{ \App\Helpers\CurrencyHelper::formatAmount($product->wholesale_price) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock_quantity <= 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="material-icons text-xs mr-1">error</i>
                                        Out of Stock
                                    </span>
                                @elseif($product->stock_quantity <= $product->min_stock_level)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="material-icons text-xs mr-1">warning</i>
                                        {{ $product->stock_quantity }} {{ $product->unit }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="material-icons text-xs mr-1">check_circle</i>
                                        {{ $product->stock_quantity }} {{ $product->unit }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1 text-blue-500">inventory_2</i>
                                    {{ $product->pieces_per_pack }} pcs/{{ $product->packaging_type }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                       title="View Details">
                                        <i class="material-icons text-base">visibility</i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="Edit Product">
                                        <i class="material-icons text-base">edit</i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this product?')" 
                                                title="Delete Product">
                                            <i class="material-icons text-base">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="material-icons text-6xl text-gray-300 mb-4">inventory_2</i>
                                    <p class="text-gray-500 text-lg mb-4">No products found</p>
                                    <a href="{{ route('products.create') }}" class="md-button md-button-primary">
                                        <i class="material-icons mr-2">add</i>
                                        Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // The DataTable is now initialized globally via datatables.js
        // This ensures no conflicts and proper functionality
    });
</script>
@endpush

@extends('layouts.material-app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')
@section('breadcrumb', 'Category Details')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Category Info Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">{{ $category->name }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('categories.edit', $category) }}" class="md-button md-button-primary">
                        <i class="material-icons mr-2">edit</i>
                        Edit
                    </a>
                    <a href="{{ route('categories.index') }}" class="md-button bg-gray-300 text-gray-700 hover:bg-gray-400">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Category Information</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="text-sm text-gray-900">{{ $category->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="text-sm text-gray-900">{{ $category->description ?? 'No description' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="text-sm text-gray-900">{{ $category->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Statistics</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Products</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $category->products_count }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Active Products</dt>
                            <dd class="text-sm text-gray-900">{{ $category->products()->where('is_active', true)->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in Category -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Products in {{ $category->name }}</h2>
        </div>
        
        <div class="md-card-content">
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 data-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity <= $product->min_stock_level ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product->id) }}" class="text-green-600 hover:text-green-900" title="View">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="material-icons">edit</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <i class="material-icons text-gray-400 text-4xl mb-2">inventory</i>
                    <p class="text-gray-500">No products found in this category.</p>
                    <a href="{{ route('products.create') }}" class="mt-2 inline-block text-blue-600 hover:underline">
                        Add your first product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            searching: false,
            paging: false,
            info: false,
            language: {
                emptyTable: "No products found"
            }
        });
    });
</script>
@endpush

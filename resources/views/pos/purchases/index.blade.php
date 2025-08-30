@extends('layouts.material-app')

@section('title', 'Purchases')
@section('page-title', 'Purchase Management')
@section('breadcrumb', 'Purchases')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">shopping_cart</i>
            </div>
            <div class="stats-card-title">Total Purchases</div>
            <div class="stats-card-value">{{ $totalPurchases ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-yellow-100 text-yellow-600">
                <i class="material-icons">pending</i>
            </div>
            <div class="stats-card-title">Pending</div>
            <div class="stats-card-value">{{ $pendingPurchases ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="stats-card-title">Total Value</div>
            <div class="stats-card-value">{{ config('currency.symbol') }}{{ number_format($totalAmount ?? 0, 2) }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">inventory</i>
            </div>
            <div class="stats-card-title">Received</div>
            <div class="stats-card-value">{{ $purchases->where('status', 'received')->count() ?? 0 }}</div>
        </div>
    </div>

    <!-- Purchases Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">All Purchase Orders</h2>
                <a href="{{ route('purchases.create') }}" class="md-button md-button-primary">
                    <i class="material-icons mr-2">add</i>
                    Create Purchase
                </a>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 data-table" id="purchasesTable">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">receipt</i>
                                    Order #
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">business</i>
                                    Supplier
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">calendar_today</i>
                                    Date
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">attach_money</i>
                                    Total
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">info</i>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">payment</i>
                                    Payment
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
                        @forelse($purchases as $purchase)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $purchase->purchase_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $purchase->supplier->company_name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $purchase->supplier->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $purchase->purchase_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-green-600">{{ config('currency.symbol') }}{{ number_format($purchase->total_amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $purchase->status_color }}-100 text-{{ $purchase->status_color }}-800">
                                    {{ ucfirst(str_replace('_', ' ', $purchase->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $purchase->payment_status_color }}-100 text-{{ $purchase->payment_status_color }}-800">
                                    {{ ucfirst($purchase->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('purchases.show', $purchase->id) }}" 
                                       class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                       title="View Details">
                                        <i class="material-icons text-base">visibility</i>
                                    </a>
                                    <a href="{{ route('purchases.edit', $purchase->id) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="Edit Purchase">
                                        <i class="material-icons text-base">edit</i>
                                    </a>
                                    @if($purchase->status === 'pending')
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this purchase order?')" 
                                                title="Delete Purchase">
                                            <i class="material-icons text-base">delete</i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="material-icons text-6xl text-gray-300 mb-4">shopping_cart</i>
                                    <p class="text-gray-500 text-lg mb-4">No purchase orders found</p>
                                    <a href="{{ route('purchases.create') }}" class="md-button md-button-primary">
                                        <i class="material-icons mr-2">add</i>
                                        Create First Purchase
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
        // Only initialize DataTable if there are actual data rows (not just the empty message)
        const table = $('#purchasesTable');
        const hasData = table.find('tbody tr').length > 1 || (table.find('tbody tr').length === 1 && !table.find('tbody tr').has('td[colspan]').length);
        
        if (hasData) {
            table.DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                language: {
                    search: "Search purchases:",
                    lengthMenu: "Show _MENU_ purchases per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ purchases",
                    infoEmpty: "No purchases found",
                    infoFiltered: "(filtered from _MAX_ total purchases)",
                    emptyTable: "No purchases available",
                    zeroRecords: "No purchases match your search",
                    paginate: {
                        first: '<i class="material-icons">first_page</i>',
                        last: '<i class="material-icons">last_page</i>',
                        next: '<i class="material-icons">chevron_right</i>',
                        previous: '<i class="material-icons">chevron_left</i>'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [6] }, // Actions column
                    { searchable: false, targets: [6] }
                ],
                dom: '<"flex justify-between items-center mb-4"<"flex items-center"l><"flex items-center"f>>rt<"flex justify-between items-center mt-4"<"flex items-center"i><"flex items-center"p>>B',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="material-icons">content_copy</i>',
                        className: 'md-button md-button-secondary',
                        titleAttr: 'Copy to clipboard'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="material-icons">download</i> CSV',
                        className: 'md-button md-button-secondary',
                        titleAttr: 'Download CSV'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="material-icons">table_view</i> Excel',
                        className: 'md-button md-button-secondary',
                        titleAttr: 'Download Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="material-icons">picture_as_pdf</i> PDF',
                        className: 'md-button md-button-secondary',
                        titleAttr: 'Download PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="material-icons">print</i> Print',
                        className: 'md-button md-button-secondary',
                        titleAttr: 'Print'
                    }
                ],
                initComplete: function() {
                    // Style the search input
                    $('.dataTables_filter input').addClass('md-input').attr('placeholder', 'Search purchases...');
                    
                    // Style the length menu
                    $('.dataTables_length select').addClass('md-input');
                    
                    // Add loading state
                    $('#purchasesTable').addClass('loaded');
                }
            });
        } else {
            // If no data, just add the loaded class
            $('#purchasesTable').addClass('loaded');
        }
    });
</script>
@endpush

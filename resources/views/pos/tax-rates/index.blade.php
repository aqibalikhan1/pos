@extends('layouts.material-app')

@section('title', 'Tax Rates')
@section('page-title', 'Tax Rates Management')
@section('breadcrumb', 'Tax Rates')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">percent</i>
            </div>
            <div class="stats-card-title">Total Tax Rates</div>
            <div class="stats-card-value">{{ $taxRates->count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">check_circle</i>
            </div>
            <div class="stats-card-title">Active Rates</div>
            <div class="stats-card-value">{{ $taxRates->where('is_active', true)->count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">receipt</i>
            </div>
            <div class="stats-card-title">Tax Types</div>
            <div class="stats-card-value">{{ $taxRates->groupBy('tax_type_id')->count() }}</div>
        </div>
    </div>

    <!-- Tax Rates Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">All Tax Rates</h2>
                <a href="{{ route('settings.tax-rates.create') }}" class="md-button md-button-primary">
                    <i class="material-icons mr-2">add</i>
                    Add Tax Rate
                </a>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 data-table" id="taxRatesTable" data-auto-init="true">
                    <thead class="bg-gradient-to-r from-purple-50 to-pink-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">receipt</i>
                                    Name
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">category</i>
                                    Tax Type
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">percent</i>
                                    Standard Rate
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">trending_down</i>
                                    Filer Rate
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">calendar_today</i>
                                    Effective Date
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">toggle_on</i>
                                    Status
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
                        @forelse($taxRates as $taxRate)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="material-icons text-purple-600 text-sm">{{ substr($taxRate->name, 0, 1) }}</i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $taxRate->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $taxRate->taxType->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $taxRate->taxType->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $taxRate->rate }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($taxRate->filer_rate !== null)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $taxRate->filer_rate }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        N/A
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $taxRate->effective_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($taxRate->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="material-icons text-xs mr-1">check_circle</i>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="material-icons text-xs mr-1">cancel</i>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('settings.tax-rates.edit', $taxRate->id) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="Edit Tax Rate">
                                        <i class="material-icons text-base">edit</i>
                                    </a>
                                    <form action="{{ route('settings.tax-rates.destroy', $taxRate->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this tax rate?')" 
                                                title="Delete Tax Rate">
                                            <i class="material-icons text-base">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="material-icons text-6xl text-gray-300 mb-4">percent</i>
                                    <p class="text-gray-500 text-lg mb-4">No tax rates found</p>
                                    <a href="{{ route('settings.tax-rates.create') }}" class="md-button md-button-primary">
                                        <i class="material-icons mr-2">add</i>
                                        Add Your First Tax Rate
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $taxRates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#taxRatesTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                search: "Search tax rates:",
                lengthMenu: "Show _MENU_ tax rates per page",
                info: "Showing _START_ to _END_ of _TOTAL_ tax rates",
                infoEmpty: "No tax rates found",
                infoFiltered: "(filtered from _MAX_ total tax rates)",
                emptyTable: "No tax rates available",
                zeroRecords: "No tax rates match your search",
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
                $('.dataTables_filter input').addClass('md-input').attr('placeholder', 'Search tax rates...');
                
                // Style the length menu
                $('.dataTables_length select').addClass('md-input');
                
                // Add loading state
                $('#taxRatesTable').addClass('loaded');
            }
        });
    });
</script>
@endpush

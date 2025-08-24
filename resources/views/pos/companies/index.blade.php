@extends('layouts.material-app')
@section('title', 'Companies')
@section('page-title', 'Manage Companies')
@section('breadcrumb', 'Companies')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">business</i>
            </div>
            <div class="stats-card-title">Total Companies</div>
            <div class="stats-card-value">{{ $totalCompanies ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">check_circle</i>
            </div>
            <div class="stats-card-title">Active Companies</div>
            <div class="stats-card-value">{{ $activeCompanies ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-red-100 text-red-600">
                <i class="material-icons">cancel</i>
            </div>
            <div class="stats-card-title">Inactive Companies</div>
            <div class="stats-card-value">{{ $inactiveCompanies ?? 0 }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">schedule</i>
            </div>
            <div class="stats-card-title">Recent Companies</div>
            <div class="stats-card-value">{{ $recentCompanies ?? 0 }}</div>
        </div>
    </div>

    <!-- Companies Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">All Companies</h2>
                <a href="{{ route('companies.create') }}" class="md-button md-button-primary">
                    <i class="material-icons mr-2">add</i>
                    Add Company
                </a>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 data-table" id="companiesTable">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">business</i>
                                    Company
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">email</i>
                                    Email
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">phone</i>
                                    Phone
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">location_on</i>
                                    Address
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
                        @forelse($companies as $company)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="material-icons text-blue-600 text-lg">business</i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $company->website ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $company->email }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $company->phone ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ Str::limit($company->address ?? 'N/A', 30) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($company->is_active)
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
                                    <a href="{{ route('companies.show', $company->id) }}" 
                                       class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                       title="View Details">
                                        <i class="material-icons text-base">visibility</i>
                                    </a>
                                    <a href="{{ route('companies.edit', $company->id) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="Edit Company">
                                        <i class="material-icons text-base">edit</i>
                                    </a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this company?')" 
                                                title="Delete Company">
                                            <i class="material-icons text-base">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="material-icons text-6xl text-gray-300 mb-4">business</i>
                                    <p class="text-gray-500 text-lg mb-4">No companies found</p>
                                    <a href="{{ route('companies.create') }}" class="md-button md-button-primary">
                                        <i class="material-icons mr-2">add</i>
                                        Add Your First Company
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination is handled by DataTables -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#companiesTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                search: "Search companies:",
                lengthMenu: "Show _MENU_ companies per page",
                info: "Showing _START_ to _END_ of _TOTAL_ companies",
                infoEmpty: "No companies found",
                infoFiltered: "(filtered from _MAX_ total companies)",
                emptyTable: "No companies available",
                zeroRecords: "No companies match your search",
                paginate: {
                    first: '<i class="material-icons">first_page</i>',
                    last: '<i class="material-icons">last_page</i>',
                    next: '<i class="material-icons">chevron_right</i>',
                    previous: '<i class="material-icons">chevron_left</i>'
                }
            },
            columnDefs: [
                { orderable: false, targets: [5] }, // Actions column
                { searchable: false, targets: [5] }
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
                $('.dataTables_filter input').addClass('md-input').attr('placeholder', 'Search companies...');
                
                // Style the length menu
                $('.dataTables_length select').addClass('md-input');
                
                // Add loading state
                $('#companiesTable').addClass('loaded');
            }
        });
    });
</script>
@endpush

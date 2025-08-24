@extends('layouts.material-app')

@section('title', 'Credit Notes')
@section('page-title', 'Credit Notes Management')
@section('breadcrumb', 'Credit Notes')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">receipt_long</i>
            </div>
            <div class="stats-card-title">Total Credit Notes</div>
            <div class="stats-card-value">{{ $creditNotes->total() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">check_circle</i>
            </div>
            <div class="stats-card-title">Approved</div>
            <div class="stats-card-value">{{ $creditNotes->where('status', 'approved')->count() }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="stats-card-title">Total Amount</div>
            <div class="stats-card-value">${{ number_format($creditNotes->sum('total_amount'), 2) }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-orange-100 text-orange-600">
                <i class="material-icons">pending</i>
            </div>
            <div class="stats-card-title">Pending</div>
            <div class="stats-card-value">{{ $creditNotes->where('status', 'pending')->count() }}</div>
        </div>
    </div>

    <!-- Credit Notes Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <h2 class="md-card-title">All Credit Notes</h2>
                <a href="{{ route('credit-notes.create') }}" class="md-button md-button-primary">
                    <i class="material-icons mr-2">add</i>
                    Add Credit Note
                </a>
            </div>
        </div>
        
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 data-table" id="creditNotesTable" data-auto-init="true">
                    <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">receipt</i>
                                    Credit Note #
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">person</i>
                                    Customer
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">event</i>
                                    Date
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">description</i>
                                    Original Invoice
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="material-icons text-sm mr-1">payments</i>
                                    Amount
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
                        @forelse($creditNotes as $creditNote)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="material-icons text-blue-600 text-sm">receipt</i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $creditNote->credit_note_number }}</div>
                                        <div class="text-sm text-gray-500">{{ $creditNote->reason ?? 'No reason specified' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $creditNote->customer->name }}</div>
                                <div class="text-sm text-gray-500">{{ $creditNote->customer->email ?? 'No email' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $creditNote->credit_note_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($creditNote->original_invoice_number)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $creditNote->original_invoice_number }}
                                </span>
                                @else
                                <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($creditNote->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($creditNote->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="material-icons text-xs mr-1">check_circle</i>
                                        Approved
                                    </span>
                                @elseif($creditNote->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="material-icons text-xs mr-1">pending</i>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="material-icons text-xs mr-1">cancel</i>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('credit-notes.show', $creditNote) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="View Credit Note">
                                        <i class="material-icons text-base">visibility</i>
                                    </a>
                                    <a href="{{ route('credit-notes.edit', $creditNote) }}" 
                                       class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors duration-200" 
                                       title="Edit Credit Note">
                                        <i class="material-icons text-base">edit</i>
                                    </a>
                                    <form action="{{ route('credit-notes.destroy', $creditNote) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                onclick="return confirm('Are you sure you want to delete this credit note?')" 
                                                title="Delete Credit Note">
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
                                    <i class="material-icons text-6xl text-gray-300 mb-4">receipt_long</i>
                                    <p class="text-gray-500 text-lg mb-4">No credit notes found</p>
                                    <a href="{{ route('credit-notes.create') }}" class="md-button md-button-primary">
                                        <i class="material-icons mr-2">add</i>
                                        Add Your First Credit Note
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
                {{ $creditNotes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#creditNotesTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                search: "Search credit notes:",
                lengthMenu: "Show _MENU_ credit notes per page",
                info: "Showing _START_ to _END_ of _TOTAL_ credit notes",
                infoEmpty: "No credit notes found",
                infoFiltered: "(filtered from _MAX_ total credit notes)",
                emptyTable: "No credit notes available",
                zeroRecords: "No credit notes match your search",
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
                $('.dataTables_filter input').addClass('md-input').attr('placeholder', 'Search credit notes...');
                
                // Style the length menu
                $('.dataTables_length select').addClass('md-input');
                
                // Add loading state
                $('#creditNotesTable').addClass('loaded');
            }
        });
    });
</script>
@endpush

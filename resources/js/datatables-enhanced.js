import $ from 'jquery';
import DataTable from 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';

// Make DataTable available globally
window.DataTable = DataTable;
window.$ = window.jQuery = $;

// Modern button styling configuration
const modernButtons = {
    copy: {
        extend: 'copy',
        text: '<i class="material-icons text-sm mr-1">content_copy</i> Copy',
        className: 'dt-button inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
        titleAttr: 'Copy to clipboard'
    },
    
    csv: {
        extend: 'csv',
        text: '<i class="material-icons text-sm mr-1">download</i> CSV',
        className: 'dt-button inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
        titleAttr: 'Download CSV file'
    },
    
    excel: {
        extend: 'excel',
        text: '<i class="material-icons text-sm mr-1">table_view</i> Excel',
        className: 'dt-button inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
        titleAttr: 'Download Excel file'
    },
    
    pdf: {
        extend: 'pdf',
        text: '<i class="material-icons text-sm mr-1">picture_as_pdf</i> PDF',
        className: 'dt-button inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
        titleAttr: 'Download PDF file'
    },
    
    print: {
        extend: 'print',
        text: '<i class="material-icons text-sm mr-1">print</i> Print',
        className: 'dt-button inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
        titleAttr: 'Print table'
    }
};

// Enhanced configuration with modern styling
const enhancedConfig = {
    responsive: true,
    pageLength: 10,
    lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
    order: [[0, 'asc']],
    
    language: {
        search: "Search:",
        lengthMenu: "Show _MENU_ entries per page",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "No entries found",
        infoFiltered: "(filtered from _MAX_ total entries)",
        emptyTable: "No data available",
        zeroRecords: "No matching records found",
        paginate: {
            first: '<i class="material-icons text-sm">first_page</i>',
            last: '<i class="material-icons text-sm">last_page</i>',
            next: '<i class="material-icons text-sm">chevron_right</i>',
            previous: '<i class="material-icons text-sm">chevron_left</i>'
        }
    },
    
    // Modern DOM structure with better button container
    dom: `<'flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6'
        <'flex flex-col sm:flex-row items-start sm:items-center gap-4'
            <'length-menu-wrapper'l>
            <'search-wrapper'f>
        >
        <'button-container flex flex-wrap gap-2'B>
    >rt<'flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-6'
        <'info-wrapper'i>
        <'pagination-wrapper'p>
    >`,
    
    // Modern button collection with dropdown
    buttons: [
        {
            extend: 'collection',
            text: '<i class="material-icons text-sm mr-1">download</i> Export',
            className: 'dt-button inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm hover:shadow-md',
            buttons: [
                modernButtons.copy,
                modernButtons.csv,
                modernButtons.excel,
                modernButtons.pdf
            ]
        },
        modernButtons.print
    ],
    
    // Enhanced styling callbacks
    initComplete: function() {
        const api = this.api();
        
        // Style search input with modern design
        $('.dataTables_filter input')
            .addClass('px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full sm:w-64 transition-all duration-200')
            .attr('placeholder', 'Search...');
        
        // Style length menu with modern design
        $('.dataTables_length select')
            .addClass('px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white');
        
        // Style info text
        $('.dataTables_info')
            .addClass('text-sm text-gray-600');
        
        // Style pagination with modern design
        $('.dataTables_paginate')
            .addClass('flex gap-1');
        
        // Add hover effects to table rows
        $(api.table().container()).find('tbody tr')
            .addClass('hover:bg-gray-50 transition-colors duration-150');
            
        // Add loading state
        $(api.table().node()).addClass('loaded');
    }
};

// Helper function to initialize DataTable with enhanced styling
window.initializeDataTable = function(tableSelector, customConfig = {}) {
    const table = document.querySelector(tableSelector);
    if (!table || table.classList.contains('dataTable')) {
        return; // Skip if already initialized
    }

    const config = { ...enhancedConfig, ...customConfig };
    return new DataTable(table, config);
};

// Auto-initialize tables (without data-auto-init requirement)
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all .data-table elements that don't have manual initialization
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        if (!table.classList.contains('dataTable')) {
            const tableId = table.getAttribute('id');
            if (tableId) {
                initializeDataTable(`#${tableId}`);
            }
        }
    });
});

// Export for use in other modules
export { DataTable, $ };

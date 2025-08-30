import $ from 'jquery';
import DataTable from 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';

// Make DataTable available globally
window.DataTable = DataTable;
window.$ = window.jQuery = $;

// Initialize DataTables with all features
document.addEventListener('DOMContentLoaded', function() {
    // Initialize only tables with the class 'data-table' AND data-auto-init="true"
    const tables = document.querySelectorAll('.data-table[data-auto-init="true"]');
    
    tables.forEach(table => {
        if (!table.classList.contains('dataTable')) {
            new DataTable(table, {
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-success'
                    }
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'asc']],
                columnDefs: [
                    {
                        targets: 'no-sort',
                        orderable: false
                    }
                ]
            });
        }
    });
});

// Export for use in other modules
export { DataTable, $ };

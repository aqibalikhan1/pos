@extends('layouts.material-app')

@section('title', 'Assign Customers - ' . $route->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Assign Customers to Route</h1>
            <p class="text-gray-600">{{ $route->name }} - {{ $route->day_name }}</p>
        </div>
        <a href="{{ route('routes.show', $route) }}" 
           class="md-button md-button-secondary">
            <i class="material-icons mr-2">arrow_back</i>
            Back to Route
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Search & Add Customers</h2>
            <p class="text-sm text-gray-600">Search customers and add them to this route</p>
        </div>

        <div class="p-6">
            <!-- Search Input -->
            <div class="mb-4">
                <input type="text" 
                       id="customer-search" 
                       placeholder="Search customers by name, email, or phone..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Selected Customers List -->
            <form method="POST" action="{{ route('routes.store-customers', $route) }}" id="customer-form">
                @csrf
                <div id="selected-customers" class="space-y-3 mb-4">
                    <!-- Selected customers will be added here -->
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('routes.show', $route) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Assign Selected Customers
                    </button>
                </div>
            </form>

            <!-- Search Results -->
            <div id="search-results" class="mt-4 border-t pt-4">
                <h3 class="text-md font-medium text-gray-900 mb-3">Search Results</h3>
                <div id="search-list" class="space-y-2 max-h-96 overflow-y-auto">
                    <!-- Search results will appear here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedCustomers = [];
        <?php
        $customersData = $availableCustomers->map(function($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address
            ];
        });
        ?>
        let allCustomers = <?php echo json_encode($customersData); ?>;

        function renderSelectedCustomers() {
            const container = document.getElementById('selected-customers');
            container.innerHTML = '';
            
            selectedCustomers.forEach((customer, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
                div.innerHTML = `
                    <div>
                        <span class="font-medium">${customer.name}</span>
                        <span class="text-sm text-gray-600 ml-2">(${customer.email})</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="customers[${index}][customer_id]" value="${customer.id}">
                        <input type="number" name="customers[${index}][visit_order]" value="${index + 1}" 
                               min="1" class="w-16 rounded-md border-gray-300 text-sm">
                        <input type="text" name="customers[${index}][notes]" placeholder="Notes" 
                               class="w-32 rounded-md border-gray-300 text-sm">
                        <button type="button" onclick="removeCustomer(${customer.id})" 
                                class="text-red-600 hover:text-red-800">
                            <i class="material-icons text-sm">remove</i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        function renderSearchResults(customers) {
            const container = document.getElementById('search-list');
            container.innerHTML = '';
            
            customers.forEach(customer => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50';
                div.innerHTML = `
                    <div>
                        <div class="font-medium">${customer.name}</div>
                        <div class="text-sm text-gray-600">${customer.email} ${customer.phone ? '| ' + customer.phone : ''}</div>
                        <div class="text-sm text-gray-500">${customer.address || ''}</div>
                    </div>
                    <button type="button" onclick="addCustomer(${customer.id})" 
                            class="md-button md-button-primary text-sm">
                        <i class="material-icons text-sm">add</i>
                        Add
                    </button>
                `;
                container.appendChild(div);
            });
        }

        function addCustomer(customerId) {
            const customer = allCustomers.find(c => c.id === customerId);
            if (customer && !selectedCustomers.find(c => c.id === customerId)) {
                selectedCustomers.push(customer);
                renderSelectedCustomers();
                renderSearchResults(allCustomers.filter(c => !selectedCustomers.find(sc => sc.id === c.id)));
            }
        }

        function removeCustomer(customerId) {
            selectedCustomers = selectedCustomers.filter(c => c.id !== customerId);
            renderSelectedCustomers();
            const searchTerm = document.getElementById('customer-search').value;
            const filtered = allCustomers.filter(c => 
                !selectedCustomers.find(sc => sc.id === c.id) &&
                (c.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                 c.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
                 (c.phone && c.phone.toLowerCase().includes(searchTerm.toLowerCase())))
            );
            renderSearchResults(filtered);
        }

        document.getElementById('customer-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filtered = allCustomers.filter(customer => 
                !selectedCustomers.find(sc => sc.id === customer.id) &&
                (customer.name.toLowerCase().includes(searchTerm) ||
                 customer.email.toLowerCase().includes(searchTerm) ||
                 (customer.phone && customer.phone.toLowerCase().includes(searchTerm)))
            );
            renderSearchResults(filtered);
        });

        // Initial render
        renderSearchResults(allCustomers);
    </script>

    @if($route->customers->isNotEmpty())
        <div class="mt-8 bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Currently Assigned Customers</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($route->customers as $customer)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
                                <p class="text-sm text-gray-600">Order: {{ $customer->pivot->visit_order }}</p>
                            </div>
                            <a href="{{ route('customers.show', $customer) }}" 
                               class="text-green-600 hover:text-green-800"
                               title="View Customer">
                                <i class="material-icons">visibility</i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

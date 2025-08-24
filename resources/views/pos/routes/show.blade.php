@extends('layouts.material-app')

@section('title', $route->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $route->name }}</h1>
            <p class="text-gray-600">{{ $route->day_name }} • {{ $route->total_customers }} customers</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('routes.assign-customers', $route) }}" 
               class="md-button md-button-primary">
                <i class="material-icons mr-2">person_add</i>
                Assign Customers
            </a>
            <a href="{{ route('routes.edit', $route) }}" 
               class="md-button md-button-secondary">
                <i class="material-icons mr-2">edit</i>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Assigned Customers</h2>
                </div>
                
                <div class="p-6">
                    @if($route->customers->isEmpty())
                        <div class="text-center py-8">
                            <i class="material-icons text-gray-400 text-6xl mb-4">people_outline</i>
                            <p class="text-gray-500 mb-4">No customers assigned to this route</p>
                            <a href="{{ route('routes.assign-customers', $route) }}" 
                               class="md-button md-button-primary">
                                <i class="material-icons mr-2">person_add</i>
                                Assign Customers
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($route->customers as $index => $customer)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-600">{{ $customer->pivot->visit_order }}</span>
                                        </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
                                <p class="text-sm text-gray-600">{{ $customer->address }}</p>
                                @if($customer->pivot->notes)
                                    <p class="text-sm text-gray-500 mt-1">{{ $customer->pivot->notes }}</p>
                                @endif
                            </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('customers.show', $customer) }}" 
                                           class="text-green-600 hover:text-green-800"
                                           title="View Customer">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <form action="{{ route('routes.remove-customer', [$route, $customer]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to remove this customer from the route?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800"
                                                    title="Remove from Route">
                                                <i class="material-icons">remove_circle_outline</i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Route Details</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Day</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $route->day_name }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $route->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $route->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    
                    @if($route->description)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Description</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $route->description }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total Customers</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $route->total_customers }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.material-app')

@section('title', 'Routes Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Routes Management</h1>
        <a href="{{ route('routes.create') }}" class="md-button md-button-primary">
            <i class="material-icons mr-2">add</i>
            Create New Route
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach([1, 2, 3, 4, 5, 6, 7] as $dayNumber)
            @php
                $dayName = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][$dayNumber - 1];
                $dayRoutes = $routes->get($dayNumber, collect());
            @endphp
            
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $dayName }}</h3>
                    <p class="text-sm text-gray-600">{{ $dayRoutes->count() }} route(s)</p>
                </div>
                
                <div class="p-4">
                    @if($dayRoutes->isEmpty())
                        <p class="text-gray-500 text-center py-4">No routes for this day</p>
                    @else
                        <div class="space-y-3">
                            @foreach($dayRoutes as $route)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $route->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $route->customers_count }} customers</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('routes.show', $route) }}" 
                                           class="text-green-600 hover:text-green-800"
                                           title="View">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a href="{{ route('routes.edit', $route) }}" 
                                           class="text-blue-600 hover:text-blue-800"
                                           title="Edit">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <a href="{{ route('routes.assign-customers', $route) }}" 
                                           class="text-purple-600 hover:text-purple-800"
                                           title="Assign Customers">
                                            <i class="material-icons">person_add</i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

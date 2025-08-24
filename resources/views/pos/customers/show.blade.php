    @extends('layouts.material-app')
@section('title', 'Customer Details')
@section('page-title', 'Customer Details')
@section('breadcrumb', 'Customers / Details')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Back Button -->
    <div class="flex items-center">
        <a href="{{ route('customers.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
            <i class="material-icons mr-2">arrow_back</i>
            Back to Customers
        </a>
    </div>

    <!-- Customer Details Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="md-card-title">Customer Details</h2>
                    <p class="text-sm text-gray-600">Complete information about {{ $customer->full_name }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('customers.edit', $customer) }}" 
                       class="md-button md-button-primary">
                        <i class="material-icons mr-2">edit</i>
                        Edit
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="md-button md-button-danger"
                                onclick="return confirm('Are you sure you want to delete this customer?')">
                            <i class="material-icons mr-2">delete</i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="md-card-content">
            <!-- Customer Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-blue-600">person</i>
                        Personal Information
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Full Name:</span>
                            <span class="text-sm text-gray-900">{{ $customer->full_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Email:</span>
                            <span class="text-sm text-gray-900">{{ $customer->email }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Phone:</span>
                            <span class="text-sm text-gray-900">{{ $customer->phone ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Status:</span>
                            <span class="text-sm">
                                @if($customer->is_active)
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
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Filer Status:</span>
                            <span class="text-sm">
                                @if($customer->is_filer)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="material-icons text-xs mr-1">account_balance</i>
                                        Registered Filer
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="material-icons text-xs mr-1">person_outline</i>
                                        Non-Filer
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-green-600">location_on</i>
                        Address Information
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Address:</span>
                            <span class="text-sm text-gray-900">{{ $customer->address ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Town:</span>
                            <span class="text-sm text-gray-900">
                                @if($customer->town)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        <i class="material-icons text-xs mr-1">location_city</i>
                                        {{ $customer->town->name }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    
                    </div>
                </div>
            </div>

            <!-- Filer Details (if applicable) -->
            @if($customer->is_filer)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-purple-600">account_balance</i>
                        Tax Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="material-icons text-blue-600 mr-2">credit_card</i>
                                <span class="text-sm font-medium text-gray-600">CNIC Number</span>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">{{ $customer->cnic ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="material-icons text-green-600 mr-2">receipt</i>
                                <span class="text-sm font-medium text-gray-600">Tax Number</span>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">{{ $customer->tax_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            @if($customer->notes)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-orange-600">note</i>
                        Additional Notes
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $customer->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- System Information -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="material-icons mr-2 text-gray-600">info</i>
                    System Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="text-sm font-medium text-gray-600">Created:</span>
                        <span class="text-sm text-gray-900">{{ $customer->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                        <span class="text-sm text-gray-900">{{ $customer->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('customers.index') }}" 
                   class="md-button md-button-secondary">
                    <i class="material-icons mr-2">arrow_back</i>
                    Back to List
                </a>
                <a href="{{ route('customers.edit', $customer) }}" 
                   class="md-button md-button-primary">
                    <i class="material-icons mr-2">edit</i>
                    Edit Customer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.material-app')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')
@section('breadcrumb', 'Employees / Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Details Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-white/10 rounded-lg mr-4">
                        <i class="material-icons text-white text-2xl">person</i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Employee Details</h2>
                        <p class="text-blue-100 text-sm">Complete information about this employee</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('employees.edit', $employee) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                        <i class="material-icons text-sm mr-2">edit</i>
                        Edit
                    </a>
                    <a href="{{ route('employees.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <i class="material-icons text-sm mr-2">arrow_back</i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Personal Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="material-icons text-blue-600 mr-2">person</i>
                        Personal Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Basic details about the employee</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">badge</i>
                            Full Name
                        </label>
                        <p class="text-lg font-medium text-gray-900">{{ $employee->getFullNameAttribute() }}</p>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">email</i>
                            Email
                        </label>
                        <p class="text-lg font-medium text-gray-900">{{ $employee->email }}</p>
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">phone</i>
                            Phone
                        </label>
                        <p class="text-lg font-medium text-gray-900">{{ $employee->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Employment Details Section -->
            <div class="space-y-6 mt-8">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="material-icons text-blue-600 mr-2">work</i>
                        Employment Details
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Employment-related information</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Employee Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">category</i>
                            Employee Type
                        </label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="material-icons text-sm mr-1">work</i>
                            {{ $employee->employee_type }}
                        </span>
                    </div>

                    <!-- Hire Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">calendar_today</i>
                            Hire Date
                        </label>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    <!-- Salary -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">attach_money</i>
                            Salary
                        </label>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $employee->salary ? '$' . number_format($employee->salary, 2) : 'N/A' }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">toggle_on</i>
                            Status
                        </label>
                        @if($employee->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="material-icons text-sm mr-1">check_circle</i>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="material-icons text-sm mr-1">cancel</i>
                                Inactive
                            </span>
                        @endif
                    </div>

                    <!-- Created Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">event</i>
                            Created
                        </label>
                        <p class="text-lg font-medium text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Updated Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">update</i>
                            Last Updated
                        </label>
                        <p class="text-lg font-medium text-gray-900">{{ $employee->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="space-y-6 mt-8">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="material-icons text-blue-600 mr-2">location_on</i>
                        Address Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Employee's contact address</p>
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="material-icons text-sm align-middle mr-1 text-blue-600">home</i>
                        Address
                    </label>
                    <p class="text-lg font-medium text-gray-900">{{ $employee->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

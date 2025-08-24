@extends('layouts.material-app')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')
@section('breadcrumb', 'Employees / Details')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Employee Details</h2>
            <p class="text-gray-600">View employee information</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('employees.edit', $employee) }}" 
               class="md-button md-button-primary">
                <i class="material-icons mr-2">edit</i>
                Edit
            </a>
            <a href="{{ route('employees.index') }}" 
               class="md-button md-button-secondary">
                <i class="material-icons mr-2">arrow_back</i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Employee Details Card -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Employee Information</h2>
            <p class="text-sm text-gray-600">Complete employee details</p>
        </div>
        
        <div class="md-card-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->getFullNameAttribute() }}</p>
                </div>

                <!-- Email -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->email }}</p>
                </div>

                <!-- Employee Type -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Employee Type</h3>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $employee->employee_type }}
                    </span>
                </div>

                <!-- Phone -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->phone ?? 'N/A' }}</p>
                </div>

                <!-- Hire Date -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Hire Date</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">
                        {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                    </p>
                </div>

                <!-- Salary -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Salary</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">
                        {{ $employee->salary ? '$' . number_format($employee->salary, 2) : 'N/A' }}
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    @if($employee->is_active)
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
                </div>

                <!-- Created Date -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Created</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                </div>

                <!-- Updated Date -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->updated_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Address -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                <p class="mt-1 text-lg font-medium text-gray-900">{{ $employee->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.material-app')

@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee')
@section('breadcrumb', 'Employees / Edit')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/10 rounded-lg mr-4">
                    <i class="material-icons text-white text-2xl">edit</i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Update Employee</h2>
                    <p class="text-blue-100 text-sm">Modify the details of this employee</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
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
                        <!-- First Name -->
                        <div class="space-y-2">
                            <label for="first_name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">badge</i>
                                First Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name" 
                                       value="{{ old('first_name', $employee->first_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('first_name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., John"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">edit</i>
                                </div>
                            </div>
                            @error('first_name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-2">
                            <label for="last_name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">badge</i>
                                Last Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name" 
                                       value="{{ old('last_name', $employee->last_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('last_name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., Doe"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">edit</i>
                                </div>
                            </div>
                            @error('last_name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">email</i>
                            Email *
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $employee->email) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                                   placeholder="e.g., john.doe@company.com"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="material-icons text-gray-400 text-sm">email</i>
                            </div>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">phone</i>
                            Phone
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $employee->phone) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 ring-red-200 @enderror"
                                   placeholder="e.g., +1 234-567-8900"
                                   maxlength="15">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <span class="text-xs text-gray-400" id="phone-count">0/15</span>
                            </div>
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Employment Details Section -->
                <div class="space-y-6">
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
                            <label for="employee_type" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">category</i>
                                Employee Type *
                            </label>
                            <div class="relative">
                                <select name="employee_type" 
                                        id="employee_type" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('employee_type') border-red-500 ring-red-200 @enderror"
                                        required>
                                    <option value="" disabled>Select employee type</option>
                                    <option value="Order Booker" {{ old('employee_type', $employee->employee_type) == 'Order Booker' ? 'selected' : '' }}>Order Booker</option>
                                    <option value="DeliveryMan" {{ old('employee_type', $employee->employee_type) == 'DeliveryMan' ? 'selected' : '' }}>DeliveryMan</option>
                                    <option value="Driver" {{ old('employee_type', $employee->employee_type) == 'Driver' ? 'selected' : '' }}>Driver</option>
                                    <option value="Helper" {{ old('employee_type', $employee->employee_type) == 'Helper' ? 'selected' : '' }}>Helper</option>
                                    <option value="Kpo" {{ old('employee_type', $employee->employee_type) == 'Kpo' ? 'selected' : '' }}>Kpo</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('employee_type')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Hire Date -->
                        <div class="space-y-2">
                            <label for="hire_date" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">calendar_today</i>
                                Hire Date
                            </label>
                            <div class="relative">
                                <input type="date" 
                                       name="hire_date" 
                                       id="hire_date" 
                                       value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('hire_date') border-red-500 ring-red-200 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">event</i>
                                </div>
                            </div>
                            @error('hire_date')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Salary -->
                        <div class="space-y-2">
                            <label for="salary" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">attach_money</i>
                                Salary
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="salary" 
                                       id="salary" 
                                       step="0.01"
                                       value="{{ old('salary', $employee->salary) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('salary') border-red-500 ring-red-200 @enderror"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">paid</i>
                                </div>
                            </div>
                            @error('salary')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="is_active" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">toggle_on</i>
                                Status
                            </label>
                            <div class="relative">
                                <select name="is_active" 
                                        id="is_active" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('is_active') border-red-500 ring-red-200 @enderror">
                                    <option value="1" {{ old('is_active', $employee->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $employee->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400">arrow_drop_down</i>
                                </div>
                            </div>
                            @error('is_active')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">location_on</i>
                            Address Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Employee's contact address</p>
                    </div>

                    <!-- Address -->
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">home</i>
                            Address
                        </label>
                        <div class="relative">
                            <textarea name="address" 
                                      id="address" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('address') border-red-500 ring-red-200 @enderror"
                                      placeholder="Enter complete address...">{{ old('address', $employee->address) }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-xs text-gray-400" id="address-count">0/500</span>
                            </div>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="material-icons text-xs mr-1">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <i class="material-icons text-sm align-middle mr-1">info</i>
                        Fields marked with * are required
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('employees.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Update Employee
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Character counters
        $('#phone').on('input', function() {
            const length = $(this).val().length;
            $('#phone-count').text(length + '/15');
        });

        $('#address').on('input', function() {
            const length = $(this).val().length;
            $('#address-count').text(length + '/500');
        });

        // Initialize counters
        $('#phone-count').text($('#phone').val().length + '/15');
        $('#address-count').text($('#address').val().length + '/500');
    });
</script>
@endpush

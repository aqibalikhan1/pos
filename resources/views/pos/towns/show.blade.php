@extends('layouts.material-app')
@section('title', 'Town Details')
@section('page-title', 'Town Details')
@section('breadcrumb', 'Towns / Details')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Back Button -->
    <div class="flex items-center">
        <a href="{{ route('towns.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
            <i class="material-icons mr-2">arrow_back</i>
            Back to Towns
        </a>
    </div>

    <!-- Town Details Card -->
    <div class="md-card">
        <div class="md-card-header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="md-card-title">Town Details</h2>
                    <p class="text-sm text-gray-600">Complete information about {{ $town->name }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('towns.edit', $town) }}" 
                       class="md-button md-button-primary">
                        <i class="material-icons mr-2">edit</i>
                        Edit
                    </a>
                    <form action="{{ route('towns.destroy', $town) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="md-button md-button-danger"
                                onclick="return confirm('Are you sure you want to delete this town?')">
                            <i class="material-icons mr-2">delete</i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="md-card-content">
            <!-- Town Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-blue-600">location_city</i>
                        Town Information
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Town Name:</span>
                            <span class="text-sm text-gray-900">{{ $town->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Status:</span>
                            <span class="text-sm">
                                @if($town->status)
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
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="material-icons mr-2 text-green-600">info</i>
                        System Information
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Created:</span>
                            <span class="text-sm text-gray-900">{{ $town->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                            <span class="text-sm text-gray-900">{{ $town->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('towns.index') }}" 
                   class="md-button md-button-secondary">
                    <i class="material-icons mr-2">arrow_back</i>
                    Back to List
                </a>
                <a href="{{ route('towns.edit', $town) }}" 
                   class="md-button md-button-primary">
                    <i class="material-icons mr-2">edit</i>
                    Edit Town
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

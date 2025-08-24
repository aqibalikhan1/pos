@extends('layouts.material-app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('breadcrumb', 'Categories / Edit')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">category</i>
            </div>
            <div class="stats-card-title">Category Name</div>
            <div class="stats-card-value">{{ $category->name }}</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">toggle_on</i>
            </div>
            <div class="stats-card-title">Status</div>
            <div class="stats-card-value">{{ $category->is_active ? 'Active' : 'Inactive' }}</div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded极 shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center">
                <div class="p-极 bg-white/10 rounded-lg mr-4">
                    <i class="material-icons text-white text-2xl">edit</i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Edit Category</h2>
                    <p class="text-blue-100 text-sm">Update category details for your inventory</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">info</i>
                            Basic Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Essential details about the category</p>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">title</i>
                                Category Name *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $category->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                                       placeholder="e.g., Electronics, Clothing, Food"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">category</i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <极 class="material-icons text-xs mr-1">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semib极 text-gray-700">
                                <i class="material-icons text-sm align-middle mr-1 text-blue-600">description</i>
                                Description (Optional)
                            </label>
                            <div class="relative">
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 ring-red-200 @enderror"
                                          placeholder="Optional description for this category">{{ old('description', $category->description) }}</textarea>
                                <div class="absolute top-3 right-3 flex items-center pointer-events-none">
                                    <i class="material-icons text-gray-400 text-sm">notes</i>
                                </div>
                            </div>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="material-icons text-xs mr-1">极</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="material-icons text-blue-600 mr-2">toggle_on</i>
                            Status Configuration
                        </h3>
                        <p class="text-sm text极-600 mt-1">Set the active status for this category</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="is_active" class="block text-sm font-semibold text-gray-700">
                            <i class="material-icons text-sm align-middle mr-1 text-blue-600">visibility</i>
                            Status
                        </label>
                        <div class="relative">
                            <select name="is_active" 
                                    id="is_active" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('is_active') border-red-500 ring-red-200 @enderror">
                                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="material-icons text-gray-400">arrow_drop_down</i>
                            </极>
                        </div>
                        @error('is_active')
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
                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2极 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="material-icons text-sm mr-2">arrow_back</i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-极 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:极-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="material-icons text-sm mr-2">save</i>
                            Update Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.material-app')

@section('title', 'Expense Summary')
@section('page-title', 'Expense Summary & Analytics')
@section('breadcrumb', 'Expenses / Summary')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="stats-card">
            <div class="stats-card-icon bg-red-100 text-red-600">
                <i class="material-icons">account_balance_wallet</i>
            </div>
            <div class="stats-card-title">Total Expenses</div>
            <div class="stats-card-value">${{ number_format($totalExpenses, 2) }}</div>
            <div class="stats-card-subtitle">All time total</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-blue-100 text-blue-600">
                <i class="material-icons">category</i>
            </div>
            <div class="stats-card-title">Categories</div>
            <div class="stats-card-value">{{ $expensesByCategory->count() }}</div>
            <div class="stats-card-subtitle">Active categories</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-green-100 text-green-600">
                <i class="material-icons">trending_up</i>
            </div>
            <div class="stats-card-title">Average Expense</div>
            <div class="stats-card-value">${{ number_format($averageExpense, 2) }}</div>
            <div class="stats-card-subtitle">Per transaction</div>
        </div>
        
        <div class="stats-card">
            <div class="stats-card-icon bg-purple-100 text-purple-600">
                <i class="material-icons">calendar_today</i>
            </div>
            <div class="stats-card-title">This Month</div>
            <div class="stats-card-value">${{ number_format($thisMonthExpenses, 2) }}</div>
            <div class="stats-card-subtitle">{{ now()->format('F Y') }}</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Category Breakdown -->
        <div class="md-card">
            <div class="md-card-header">
                <h2 class="md-card-title">Expenses by Category</h2>
                <p class="md-card-subtitle">Breakdown of expenses across categories</p>
            </div>
            <div class="md-card-content">
                <div class="space-y-4">
                    @foreach($expensesByCategory as $category)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $loop->index % 2 == 0 ? '#3B82F6' : '#EF4444' }}"></div>
                            <span class="font-medium">{{ $category->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">${{ number_format($category->total, 2) }}</div>
                            <div class="text-sm text-gray-500">{{ number_format(($category->total / $totalExpenses) * 100, 1) }}%</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Progress bars visualization -->
                <div class="mt-6 space-y-3">
                    @foreach($expensesByCategory->take(5) as $category)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>{{ $category->category->name ?? 'Uncategorized' }}</span>
                            <span>{{ number_format(($category->total / $totalExpenses) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($category->total / $totalExpenses) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Monthly Trend -->
        <div class="md-card">
            <div class="md-card-header">
                <h2 class="md-card-title">Monthly Trend</h2>
                <p class="md-card-subtitle">Last 6 months expense trend</p>
            </div>
            <div class="md-card-content">
                <div class="space-y-4">
                    @foreach($monthlyTrend as $month)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ $month->month_name }}</span>
                        <span class="font-bold text-gray-900">${{ number_format($month->total, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="md-card">
        <div class="md-card-header">
            <h2 class="md-card-title">Recent Expenses</h2>
            <p class="md-card-subtitle">Latest 10 expense records</p>
        </div>
        <div class="md-card-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentExpenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $expense->expense_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $expense->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($expense->description, 30) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('expenses.show', $expense) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript for charts or interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips or other interactive elements
        const tooltips = document.querySelectorAll('[data-tooltip]');
        tooltips.forEach(tooltip => {
            // Add tooltip functionality if needed
        });
    });
</script>
@endpush

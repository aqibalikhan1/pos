<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('category')->latest()->paginate(10);
        return view('pos.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('pos.expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'receipt_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|string|in:daily,weekly,monthly,yearly',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('pos.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = Category::where('is_active', true)->get();
        return view('pos.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'receipt_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|string|in:daily,weekly,monthly,yearly',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    /**
     * Get expenses by category
     */
    public function byCategory(Category $category)
    {
        $expenses = $category->expenses()->paginate(10);
        return view('pos.expenses.index', compact('expenses', 'category'));
    }

    /**
     * Get expense summary
     */
    public function summary()
    {
     
        $totalExpenses = Expense::sum('amount');
        $expensesByCategory = Expense::selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();
        
        $averageExpense = Expense::avg('amount') ?? 0;
        $thisMonthExpenses = Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount') ?? 0;
        
        $monthlyTrend = Expense::selectRaw('
            DATE_FORMAT(expense_date, "%Y-%m") as month,
            DATE_FORMAT(expense_date, "%M %Y") as month_name,
            SUM(amount) as total
        ')
        ->where('expense_date', '>=', now()->subMonths(6))
        ->groupBy('month', 'month_name')
        ->orderBy('month')
        ->get();
        
        $recentExpenses = Expense::with('category')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('pos.expenses.summary', compact(
            'totalExpenses', 
            'expensesByCategory', 
            'averageExpense', 
            'thisMonthExpenses',
            'monthlyTrend',
            'recentExpenses'
        ));
    }
}

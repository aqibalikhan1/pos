@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expense Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ID</label>
                                <p class="form-control-static">{{ $expense->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <p class="form-control-static">
                                    <span class="badge badge-primary">{{ $expense->category->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <p class="form-control-static">{{ $expense->description }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <p class="form-control-static">{{ \App\Helpers\CurrencyHelper::formatAmount($expense->amount) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expense Date</label>
                                <p class="form-control-static">{{ $expense->expense_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Receipt Number</label>
                                <p class="form-control-static">{{ $expense->receipt_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recurring Expense</label>
                                <p class="form-control-static">
                                    @if($expense->is_recurring)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Frequency</label>
                                <p class="form-control-static">
                                    @if($expense->is_recurring)
                                        <span class="badge badge-info">{{ ucfirst($expense->recurring_frequency) }}</span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Notes</label>
                                <p class="form-control-static">{{ $expense->notes ?? 'No notes provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Created At</label>
                                <p class="form-control-static">{{ $expense->created_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Updated At</label>
                                <p class="form-control-static">{{ $expense->updated_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

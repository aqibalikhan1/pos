<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'mobile',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'tax_number',
        'credit_limit',
        'current_balance',
        'payment_terms',
        'supplier_type',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return $this->contact_name;
    }

    public function getDisplayNameAttribute()
    {
        return $this->company_name . ' - ' . $this->contact_name;
    }

    /**
     * Get the supplier's account.
     */
    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    /**
     * Scope a query to only include active suppliers.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Get all purchases for this supplier.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get all supplier payments for this supplier.
     */
    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    /**
     * Get total purchases amount for this supplier.
     */
    public function getTotalPurchasesAttribute()
    {
        return $this->purchases()->sum('total_amount');
    }

    /**
     * Get total payments made to this supplier.
     */
    public function getTotalPaymentsAttribute()
    {
        return $this->supplierPayments()->sum('amount');
    }

    /**
     * Get outstanding balance (total purchases - total payments).
     */
    public function getOutstandingBalanceAttribute()
    {
        return $this->total_purchases - $this->total_payments;
    }

    /**
     * Get credit utilization percentage.
     */
    public function getCreditUtilizationAttribute()
    {
        if ($this->credit_limit <= 0) {
            return 0;
        }

        return min(100, ($this->current_balance / $this->credit_limit) * 100);
    }

    /**
     * Get purchase statistics by status.
     */
    public function getPurchaseStatisticsAttribute()
    {
        return $this->purchases()
            ->selectRaw('status, COUNT(*) as count, SUM(total_amount) as total_amount')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => [
                    'count' => $item->count,
                    'total_amount' => $item->total_amount
                ]];
            });
    }

    /**
     * Get payment statistics by method.
     */
    public function getPaymentStatisticsAttribute()
    {
        return $this->supplierPayments()
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('payment_method')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->payment_method => [
                    'count' => $item->count,
                    'total_amount' => $item->total_amount
                ]];
            });
    }

    /**
     * Get aging analysis of outstanding purchases.
     */
    public function getAgingAnalysisAttribute()
    {
        $now = now();
        $aging = [
            'current' => 0,
            '1-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            'over_90' => 0
        ];

        $this->purchases()
            ->where('payment_status', '!=', 'paid')
            ->get()
            ->each(function ($purchase) use ($now, &$aging) {
                $daysDiff = $now->diffInDays($purchase->purchase_date);
                $outstandingAmount = $purchase->total_amount - $purchase->accountTransactions()
                    ->where('transaction_type', 'credit')
                    ->sum('amount');

                if ($outstandingAmount <= 0) {
                    return;
                }

                if ($daysDiff <= 30) {
                    $aging['current'] += $outstandingAmount;
                } elseif ($daysDiff <= 60) {
                    $aging['1-30'] += $outstandingAmount;
                } elseif ($daysDiff <= 90) {
                    $aging['31-60'] += $outstandingAmount;
                } elseif ($daysDiff <= 120) {
                    $aging['61-90'] += $outstandingAmount;
                } else {
                    $aging['over_90'] += $outstandingAmount;
                }
            });

        return $aging;
    }

    /**
     * Get average payment time in days.
     */
    public function getAveragePaymentTimeAttribute()
    {
        $payments = $this->supplierPayments()
            ->with('purchase')
            ->whereNotNull('purchase_id')
            ->get();

        if ($payments->isEmpty()) {
            return null;
        }

        $totalDays = 0;
        $count = 0;

        foreach ($payments as $payment) {
            if ($payment->purchase) {
                $daysDiff = $payment->payment_date->diffInDays($payment->purchase->purchase_date);
                $totalDays += $daysDiff;
                $count++;
            }
        }

        return $count > 0 ? round($totalDays / $count, 1) : null;
    }
}

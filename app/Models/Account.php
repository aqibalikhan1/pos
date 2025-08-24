<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'account_name',
        'account_type',
        'accountable_id',
        'accountable_type',
        'opening_balance',
        'current_balance',
        'credit_limit',
        'currency',
        'description',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function accountable()
    {
        return $this->morphTo();
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class);
    }

    /**
     * Get all purchases associated with this account.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedBalanceAttribute()
    {
        return number_format($this->current_balance, 2);
    }

    public function getFormattedCreditLimitAttribute()
    {
        return number_format($this->credit_limit, 2);
    }

    public function getAvailableCreditAttribute()
    {
        return max(0, $this->credit_limit - $this->current_balance);
    }

    public function scopeCustomer($query)
    {
        return $query->where('account_type', 'customer');
    }

    public function scopeSupplier($query)
    {
        return $query->where('account_type', 'supplier');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('account_type', $type);
    }
}

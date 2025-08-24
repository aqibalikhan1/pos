<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_type_id',
        'name',
        'rate',
        'fixed_amount',
        'effective_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'fixed_amount' => 'decimal:2',
        'effective_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function taxType()
    {
        return $this->belongsTo(TaxType::class);
    }

    public function productTaxMappings()
    {
        return $this->hasMany(ProductTaxMapping::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tax_mappings')
            ->withPivot(['is_inclusive', 'transaction_type'])
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('effective_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }
}

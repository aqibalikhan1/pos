<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'sku',
        'price',
        'cost_price',
        'category_id',
        'stock_quantity',
        'min_stock_level',
        'barcode',
        'unit',
        'is_active',
        'packaging_type',
        'pieces_per_pack'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
        'pieces_per_pack' => 'integer'
    ];

    public function packaging()
    {
        return $this->hasMany(ProductPackagings::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getTotalPiecesAttribute()
    {
        return $this->stock_quantity * $this->pieces_per_pack;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->stock_quantity <= $this->min_stock_level) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    public function taxRates()
    {
        return $this->belongsToMany(TaxRate::class, 'product_tax_mappings')
            ->withPivot(['is_inclusive', 'transaction_type'])
            ->withTimestamps();
    }

    public function scopeWithTaxRatesFor($query, $transactionType)
    {
        return $query->with(['taxRates' => function ($query) use ($transactionType) {
            $query->where(function ($q) use ($transactionType) {
                $q->where('product_tax_mappings.transaction_type', $transactionType)
                  ->orWhere('product_tax_mappings.transaction_type', 'both');
            });
        }]);
    }

    public function productTaxMappings()
    {
        return $this->hasMany(ProductTaxMapping::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTaxMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tax_rate_id',
        'is_inclusive',
        'transaction_type'
    ];

    protected $casts = [
        'is_inclusive' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'transaction_type',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
    }

    public function productTaxMappings()
    {
        return $this->hasManyThrough(ProductTaxMapping::class, TaxRate::class);
    }
}

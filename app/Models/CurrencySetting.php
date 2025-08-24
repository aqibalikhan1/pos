<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_code',
        'currency_symbol',
        'currency_name',
        'decimal_places',
        'thousands_separator',
        'decimal_separator',
        'symbol_first',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'symbol_first' => 'boolean',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get the active currency
     */
    public static function getActiveCurrency()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Get currency by code
     */
    public static function getByCode(string $code)
    {
        return self::where('currency_code', $code)->first();
    }
}

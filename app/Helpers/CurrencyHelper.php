<?php

namespace App\Helpers;

use App\Models\CurrencySetting;
use App\Services\CurrencyService;

class CurrencyHelper
{
    /**
     * Get the currency symbol from default settings
     */
    public static function getCurrencySymbol(): string
    {
        $currencyService = app(CurrencyService::class);
        return $currencyService->getSymbol();
    }

    /**
     * Format amount with default currency symbol
     */
    public static function formatAmount(float $amount): string
    {
        $currencyService = app(CurrencyService::class);
        return $currencyService->formatAmount($amount);
    }

    /**
     * Get the default currency from database
     */
    public static function getDefaultCurrency(): ?CurrencySetting
    {
        return CurrencySetting::where('is_default', true)->first();
    }

    /**
     * Get the default currency code from database
     */
    public static function getDefaultCurrencyCode(): string
    {
        $default = self::getDefaultCurrency();
        return $default ? $default->currency_code : 'USD';
    }

    /**
     * Get active currencies from database
     */
    public static function getActiveCurrencies(): array
    {
        return CurrencySetting::where('is_active', true)->get()->toArray();
    }

    /**
     * Format amount with specific currency
     */
    public static function formatAmountWithCurrency(float $amount, string $currencyCode): string
    {
        $currencyService = app(CurrencyService::class);
        return $currencyService->formatAmount($amount, $currencyCode);
    }

    /**
     * Check if currency exists in database
     */
    public static function currencyExists(string $currencyCode): bool
    {
        return CurrencySetting::where('currency_code', $currencyCode)->where('is_active', true)->exists();
    }
}

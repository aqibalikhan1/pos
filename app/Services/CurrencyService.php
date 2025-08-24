<?php

namespace App\Services;

use App\Models\CurrencySetting;
use Illuminate\Support\Facades\Config;

class CurrencyService
{
    protected $defaultCurrency;
    protected $currencies;

    public function __construct()
    {
        $this->defaultCurrency = Config::get('currency.default');
        $this->currencies = Config::get('currency.currencies');
    }

    /**
     * Get the default currency code
     */
    public function getDefaultCurrency(): string
    {
        return $this->defaultCurrency;
    }

    /**
     * Get currency details
     */
    public function getCurrency(string $code = null): array
    {
        $code = $code ?? $this->defaultCurrency;
        
        // Check if we have database currency settings
        $currencySetting = CurrencySetting::where('currency_code', $code)->where('is_active', true)->first();
        
        if ($currencySetting) {
            return [
                'name' => $currencySetting->currency_name,
                'symbol' => $currencySetting->currency_symbol,
                'code' => $currencySetting->currency_code,
                'precision' => $currencySetting->decimal_places,
                'decimal_separator' => $currencySetting->decimal_separator,
                'thousand_separator' => $currencySetting->thousands_separator,
                'symbol_first' => $currencySetting->symbol_first,
            ];
        }

        // Fallback to config
        return $this->currencies[$code] ?? $this->currencies[$this->defaultCurrency];
    }

    /**
     * Format amount with currency symbol
     */
    public function formatAmount(float $amount, string $currency = null): string
    {
        $currency = $currency ?? $this->getDefaultCurrency();
        $currencyDetails = $this->getCurrency($currency);
        
        $formatted = number_format(
            $amount,
            $currencyDetails['precision'],
            $currencyDetails['decimal_separator'],
            $currencyDetails['thousand_separator']
        );

        if ($currencyDetails['symbol_first']) {
            return $currencyDetails['symbol'] . $formatted;
        }

        return $formatted . $currencyDetails['symbol'];
    }

    /**
     * Get all available currencies
     */
    public function getAvailableCurrencies(): array
    {
        // Get active currencies from database
        $activeCurrencies = CurrencySetting::where('is_active', true)->get();
        
        if ($activeCurrencies->isNotEmpty()) {
            $currencies = [];
            foreach ($activeCurrencies as $setting) {
                $currencies[$setting->currency_code] = [
                    'name' => $setting->currency_name,
                    'symbol' => $setting->currency_symbol,
                    'code' => $setting->currency_code,
                    'precision' => $setting->decimal_places,
                    'thousand_separator' => $setting->thousands_separator,
                    'decimal_separator' => $setting->decimal_separator,
                    'symbol_first' => $setting->symbol_first,
                ];
            }
            return $currencies;
        }

        // Fallback to config
        return $this->currencies;
    }

    /**
     * Get currency symbol
     */
    public function getSymbol(string $currency = null): string
    {
        $currencyDetails = $this->getCurrency($currency);
        return $currencyDetails['symbol'];
    }

    /**
     * Convert amount to default currency (placeholder for future implementation)
     */
    public function convertToDefault(float $amount, string $fromCurrency): float
    {
        // For now, return the same amount
        // Future implementation will include actual conversion rates
        return $amount;
    }

    /**
     * Check if currency exists
     */
    public function currencyExists(string $code): bool
    {
        // Check database first
        $existsInDb = CurrencySetting::where('currency_code', $code)->where('is_active', true)->exists();
        if ($existsInDb) {
            return true;
        }

        // Check config
        return isset($this->currencies[$code]);
    }
}

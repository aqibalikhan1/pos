<?php

namespace App\Services;

use App\Models\CurrencySetting;
use Illuminate\Support\Facades\Config;

class DatabaseCurrencyService
{
    /**
     * Get the default currency from database settings
     */
    public function getDefaultCurrency(): string
    {
        $defaultSetting = CurrencySetting::where('is_default', true)->first();
        return $defaultSetting ? $defaultSetting->currency_code : Config::get('currency.default');
    }

    /**
     * Get currency details from database or fallback to config
     */
    public function getCurrency(string $code = null): array
    {
        $code = $code ?? $this->getDefaultCurrency();
        
        // Try to get from database first
        $currencySetting = CurrencySetting::where('currency_code', $code)->where('is_active', true)->first();
        
        if ($currencySetting) {
            return [
                'name' => $currencySetting->currency_name,
                'symbol' => $currencySetting->currency_symbol,
                'code' => $currencySetting->currency_code,
                'precision' => $currencySetting->decimal_places,
                'thousand_separator' => $currencySetting->thousands_separator,
                'decimal_separator' => $currencySetting->decimal_separator,
                'symbol_first' => $currencySetting->symbol_first,
            ];
        }

        // Fallback to config
        return Config::get('currency.currencies.' . $code) ?? Config::get('currency.currencies.' . Config::get('currency.default'));
    }

    /**
     * Format amount with currency symbol from database
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

        return $currencyDetails['symbol_first'] 
            ? $currencyDetails['symbol'] . $formatted
            : $formatted . $currencyDetails['symbol'];
    }

    /**
     * Get all active currencies from database
     */
    public function getActiveCurrencies(): array
    {
        $currencies = [];
        $settings = CurrencySetting::where('is_active', true)->get();
        
        foreach ($settings as $setting) {
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
}

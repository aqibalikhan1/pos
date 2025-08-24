<?php

namespace App\Providers;

use App\Models\CurrencySetting;
use App\Models\SupplierPayment;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        
        // Set up morph mapping for polymorphic relationships
        Relation::morphMap([
            'supplier_payment' => SupplierPayment::class,
            'purchase' => Purchase::class,
            // Add other mappings as necessary
        ]);

        // Override currency configuration with database settings
        $this->overrideCurrencyConfiguration();
    }

    /**
     * Override currency configuration with database settings
     */
    protected function overrideCurrencyConfiguration(): void
    {
        // Get the default currency from database
        $defaultCurrency = CurrencySetting::where('is_default', true)->first();
        
        if ($defaultCurrency) {
            // Override the default currency in config
            Config::set('currency.default', $defaultCurrency->currency_code);
            
            // Override currency symbol and other settings
            Config::set('currency.symbol', $defaultCurrency->currency_symbol);
            Config::set('currency.decimals', $defaultCurrency->decimal_places);
            Config::set('currency.thousands_separator', $defaultCurrency->thousands_separator);
            Config::set('currency.decimal_separator', $defaultCurrency->decimal_separator);
            
            // Add the currency to available currencies if not exists
            $currencies = Config::get('currency.currencies', []);
            if (!isset($currencies[$defaultCurrency->currency_code])) {
                $currencies[$defaultCurrency->currency_code] = [
                    'name' => $defaultCurrency->currency_name,
                    'symbol' => $defaultCurrency->currency_symbol,
                    'code' => $defaultCurrency->currency_code,
                    'precision' => $defaultCurrency->decimal_places,
                    'thousand_separator' => $defaultCurrency->thousands_separator,
                    'decimal_separator' => $defaultCurrency->decimal_separator,
                    'symbol_first' => $defaultCurrency->symbol_first,
                ];
                Config::set('currency.currencies', $currencies);
            }
        }
    }
}

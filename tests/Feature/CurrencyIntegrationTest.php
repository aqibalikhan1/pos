<?php

namespace Tests\Feature;

use App\Models\CurrencySetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CurrencyIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_database_currency_settings_when_available()
    {
        // Create a PKR currency setting
        $pkrSetting = CurrencySetting::create([
            'currency_code' => 'PKR',
            'currency_symbol' => 'Rs',
            'currency_name' => 'Pakistani Rupee',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_first' => true,
            'is_active' => true,
            'is_default' => true,
        ]);

        // Refresh the application to trigger AppServiceProvider
        $this->refreshApplication();

        // Assert that the default currency is now PKR
        $this->assertEquals('PKR', Config::get('currency.default'));
        $this->assertEquals('Rs', Config::get('currency.symbol'));
    }

    /** @test */
    public function it_falls_back_to_config_when_no_database_settings()
    {
        // Ensure no currency settings in database
        CurrencySetting::truncate();

        // Refresh the application
        $this->refreshApplication();

        // Assert fallback to config
        $this->assertEquals('USD', Config::get('currency.default'));
    }
}

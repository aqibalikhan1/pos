<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This value is the default currency that will be used across the application.
    | You can change this to any valid ISO 4217 currency code.
    |
    */

    'default' => env('CURRENCY_DEFAULT', 'USD'),

    /*
    |--------------------------------------------------------------------------
    | Currency Symbol
    |--------------------------------------------------------------------------
    |
    | The symbol that will be displayed with currency values.
    |
    */

    'symbol' => env('CURRENCY_SYMBOL', '$'),

    /*
    |--------------------------------------------------------------------------
    | Currency Position
    |--------------------------------------------------------------------------
    |
    | Whether the currency symbol should be displayed before or after the amount.
    | Options: 'before', 'after'
    |
    */

    'position' => env('CURRENCY_POSITION', 'before'),

    /*
    |--------------------------------------------------------------------------
    | Thousands Separator
    |--------------------------------------------------------------------------
    |
    | The character used to separate thousands in currency values.
    |
    */

    'thousands_separator' => env('CURRENCY_THOUSANDS_SEPARATOR', ','),

    /*
    |--------------------------------------------------------------------------
    | Decimal Separator
    |--------------------------------------------------------------------------
    |
    | The character used to separate decimals in currency values.
    |
    */

    'decimal_separator' => env('CURRENCY_DECIMAL_SEPARATOR', '.'),

    /*
    |--------------------------------------------------------------------------
    | Number of Decimals
    |--------------------------------------------------------------------------
    |
    | The number of decimal places to display for currency values.
    |
    */

    'decimals' => env('CURRENCY_DECIMALS', 2),

    /*
    |--------------------------------------------------------------------------
    | Available Currencies
    |--------------------------------------------------------------------------
    |
    | List of available currencies with their details.
    |
    */

    'currencies' => [
        'USD' => [
            'name' => 'US Dollar',
            'symbol' => '$',
            'code' => 'USD',
            'precision' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
            'symbol_first' => true,
        ],
        'PKR' => [
            'name' => 'Pakistani Rupee',
            'symbol' => 'Rs',
            'code' => 'PKR',
            'precision' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
            'symbol_first' => true,
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'code' => 'EUR',
            'precision' => 2,
            'thousand_separator' => '.',
            'decimal_separator' => ',',
            'symbol_first' => true,
        ],
        'GBP' => [
            'name' => 'British Pound',
            'symbol' => '£',
            'code' => 'GBP',
            'precision' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
            'symbol_first' => true,
        ],
    ],
];

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 3)->default('USD');
            $table->string('currency_symbol', 10)->default('$');
            $table->string('currency_name', 50)->default('US Dollar');
            $table->integer('decimal_places')->default(2);
            $table->string('thousands_separator')->default(',');
            $table->string('decimal_separator')->default('.');
            $table->boolean('symbol_first')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default currency settings
        \Illuminate\Support\Facades\DB::table('currency_settings')->insert([
            [
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'currency_name' => 'US Dollar',
                'decimal_places' => 2,
                'thousands_separator' => ',',
                'decimal_separator' => '.',
                'symbol_first' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'currency_code' => 'PKR',
                'currency_symbol' => 'Rs',
                'currency_name' => 'Pakistani Rupee',
                'decimal_places' => 2,
                'thousands_separator' => ',',
                'decimal_separator' => '.',
                'symbol_first' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_settings');
    }
};

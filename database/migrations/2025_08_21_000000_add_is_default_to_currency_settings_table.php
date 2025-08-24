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
        Schema::table('currency_settings', function (Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('is_active');
        });
        
        // Set the first currency as default
        \App\Models\CurrencySetting::where('currency_code', 'USD')->update(['is_default' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('currency_settings', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->enum('transaction_type', ['both', 'sale', 'purchase'])
                  ->default('both')
                  ->after('is_inclusive');
        });
    }

    public function down()
    {
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
};

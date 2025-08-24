<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop foreign key constraints temporarily
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['tax_rate_id']);
        });

        // Add the transaction_type column
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->enum('transaction_type', ['sale', 'purchase', 'both'])->default('both')->after('is_inclusive');
        });

        // Update the unique constraint to include transaction_type
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->dropUnique(['product_id', 'tax_rate_id']);
            $table->unique(['product_id', 'tax_rate_id', 'transaction_type']);
        });

        // Re-add foreign key constraints
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
        });
    }

    public function down()
    {
        // First, drop foreign key constraints temporarily
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['tax_rate_id']);
        });

        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->dropUnique(['product_id', 'tax_rate_id', 'transaction_type']);
            $table->dropColumn('transaction_type');
            $table->unique(['product_id', 'tax_rate_id']);
        });

        // Re-add foreign key constraints
        Schema::table('product_tax_mappings', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_tax_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('tax_rate_id')->constrained('tax_rates')->onDelete('cascade');
            $table->boolean('is_inclusive')->default(false); // Whether tax is included in price
            $table->timestamps();
            
            $table->unique(['product_id', 'tax_rate_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_tax_mappings');
    }
};

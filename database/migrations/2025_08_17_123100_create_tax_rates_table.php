<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_type_id')->constrained('tax_types')->onDelete('cascade');
            $table->string('name');
            $table->decimal('rate', 5, 2); // e.g., 15.00 for 15%
            $table->decimal('fixed_amount', 10, 2)->nullable(); // for fixed amount taxes
            $table->date('effective_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['tax_type_id', 'effective_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_rates');
    }
};

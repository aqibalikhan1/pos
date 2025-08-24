<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('account_name');
            $table->string('account_type'); // customer, supplier, expense, income, asset, liability
            $table->unsignedBigInteger('accountable_id')->nullable();
            $table->string('accountable_type')->nullable();
            $table->decimal('opening_balance', 10, 2)->default(0.00);
            $table->decimal('current_balance', 10, 2)->default(0.00);
            $table->decimal('credit_limit', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('PKR');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['accountable_type', 'accountable_id']);
            $table->index('account_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};

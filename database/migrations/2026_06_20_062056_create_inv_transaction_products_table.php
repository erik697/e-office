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
        Schema::create('inv_transaction_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('inv_transactions');
            $table->foreignId('product_id')->constrained('inv_products');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_transaction_products');
    }
};

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
        Schema::create('inv_products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('inv_categories');
            $table->foreignId('location_id')->constrained('inv_locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_products');
    }
};

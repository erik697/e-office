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
        Schema::create('arc_documents', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->date('register');
            $table->string('file_path', 255);
            $table->enum('status', ['pending', 'approved', 'rejected','sender'])->default('pending');
            $table->foreignId('category_id')->constrained('arc_categories')->onDelete('cascade');
            $table->enum('type', ['incoming', 'outgoing'])->default('incoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arc_documents');
    }
};

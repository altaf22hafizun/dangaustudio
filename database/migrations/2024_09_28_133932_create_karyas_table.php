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
        Schema::create('karyas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seniman_id')->constrained('senimen')->cascadeOnDelete();
            $table->foreignId('pameran_id')->nullable()->constrained('pamerans')->cascadeOnDelete();
            $table->string('name');
            $table->text('deskripsi');
            $table->unsignedInteger('price');
            $table->string('category');
            $table->string('medium');
            $table->string('size');
            $table->string('tahun');
            $table->string('image');
            $table->enum('stock', ['Tersedia', 'Terjual'])->default('Tersedia');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyas');
    }
};

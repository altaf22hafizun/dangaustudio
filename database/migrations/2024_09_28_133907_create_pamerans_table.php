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
        Schema::create('pamerans', function (Blueprint $table) {
            $table->id();
            $table->string('name_pameran');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->enum('status_publikasi', ['Published', 'Hidden'])->default('Hidden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pamerans');
    }
};

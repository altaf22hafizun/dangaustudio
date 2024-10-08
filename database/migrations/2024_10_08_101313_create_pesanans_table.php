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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Pengguna yang membuat pesanan
            $table->foreignId('karya_id')->constrained('karyas')->cascadeOnDelete(); // Karya yang dipilih
            $table->unsignedInteger('jumlah'); // Jumlah karya yang dipilih
            $table->unsignedInteger('price');  // Harga karya
            $table->enum('status', ['Pending', 'Checkout'])->default('Pending'); // Status pesanan
            $table->string('trx_id')->nullable(); // Hubungkan ke trx_id transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

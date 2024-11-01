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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnDelete();
            $table->string('trx_id');
            $table->date('tgl_transaksi');
            $table->string('proof')->nullable();
            $table->enum('status_pembayaran', ['Pending', 'Lunas', 'Dibatalkan'])->default('Pending');
            $table->enum('metode_pengiriman', ['Dijemput', 'Diantarkan'])->default('Dijemput');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};

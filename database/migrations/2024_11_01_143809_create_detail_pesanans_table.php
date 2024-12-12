<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('trx_id')->unique();
            $table->timestamp('tgl_transaksi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('total_harga');
            $table->enum('status_pembayaran', ['Menunggu Pembayaran dan Pengiriman', 'Pembayaran Diterima, Sedang Diproses untuk Pengiriman', 'Pengiriman Berhasil, Pembayaran Lunas'])->default('Menunggu Pembayaran dan Pengiriman');
            $table->enum('metode_pengiriman', ['Dijemput', 'Diantarkan'])->default('Dijemput');
            $table->string('alamat')->nullable();
            $table->string('resi_pengiriman')->nullable();
            $table->string('jenis_pengiriman');
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

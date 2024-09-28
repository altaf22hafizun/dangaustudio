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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karya_id')->constrained('karyas')->cascadeOnDelete();
            $table->string('trx');
            $table->date('tgl_transaksi');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('price');
            $table->string('proof');
            $table->enum('status_pembayaran', ['Pending', 'Lunas', 'Dibatalkan'])->default('Pending');
            $table->enum('opsi_pengambilan', ['Dijemput', 'Diantarkan'])->default('Dijemput');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

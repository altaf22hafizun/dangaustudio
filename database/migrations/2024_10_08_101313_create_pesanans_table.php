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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('trx_id')->unique();
            $table->unsignedInteger('price_total');
            $table->timestamp('tgl_transaksi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['Belum Bayar','Dikemas','Dikirim','Selesai', 'Dibatalkan']);
            $table->enum('metode_pengiriman', ['Dijemput', 'Diantarkan'])->default('Dijemput');
            $table->string('alamat')->nullable();
            $table->string('resi_pengiriman')->nullable();
            $table->string('jenis_pengiriman')->nullable();
            $table->unsignedInteger('ongkir')->nullable();
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

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
        Schema::create('data_tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('santri_id');
            $table->unsignedBigInteger('jenis_tagihan_id')->nullable();
            $table->string('bulan')->nullable();
            $table->string('thn_ajaran')->nullable();
            $table->decimal('nominal_tagihan', 15, 2);            
            $table->enum('status_pembayaran', ['Belum Bayar', 'Sudah Bayar'])->default('Belum Bayar');
            $table->timestamps();

            $table->foreign('santri_id')->references('id')->on('data_santris');
            $table->foreign('jenis_tagihan_id')->references('id')->on('jenis_tagihans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tagihans');
    }
};

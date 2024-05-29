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
        Schema::create('data_pembayarans', function (Blueprint $table) {
            $table->id();                                   
            $table->unsignedBigInteger('tagihan_id');
            $table->unsignedBigInteger('jenis_tagihan_id')->nullable();
            $table->decimal('nominal_tagihan', 15, 2);
            $table->string('metode');            
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();

            
            $table->foreign('tagihan_id')->references('id')->on('data_tagihans');
            $table->foreign('jenis_tagihan_id')->references('id')->on('jenis_tagihans');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pembayarans');
    }
};

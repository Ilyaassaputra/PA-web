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
        Schema::create('data_pendaftars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Menambahkan kolom user_id sebagai foreign key
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');                        
            $table->string('jenis_kelamin');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->text('alamat');
            $table->string('no_hp');  
            $table->string('foto');   
            $table->enum('status', [1,2,3 ])->default(1);    // 1 = belum bayar || 2 = menunggu kofirmasi || 3 = konfirmasi
            $table ->string('bukti_pembayaran')->nullable()->default(null);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('id')->on('list_sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pendaftars');
    }
};

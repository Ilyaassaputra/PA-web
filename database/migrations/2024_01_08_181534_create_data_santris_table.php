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
        Schema::create('data_santris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tempat_lahir');            
            $table->date('tanggal_lahir');            
            $table->string('jenis_kelamin');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'lulus'])->default('aktif');
            $table->unsignedBigInteger('data_pendaftar_id')->nullable();
            $table->timestamps();
            
            $table->foreign('data_pendaftar_id')->references('id')->on('data_pendaftars')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('id')->on('list_sekolahs');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_santris');
        Schema::table('data_santris', function (Blueprint $table) {
            $table->dropForeign(['data_pendaftar_id']);
            $table->dropColumn('data_pendaftar_id');
        });
    }
};

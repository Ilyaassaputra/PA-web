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
        Schema::table('data_pembayarans', function (Blueprint $table) {
            $table->decimal('jumlah_dibayar', 20, 2)->default(0)->after('nominal_tagihan');
            $table->decimal('sisa_pembayaran', 20, 2)->after('jumlah_dibayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pembayarans', function (Blueprint $table) {
            $table->dropColumn('jumlah_dibayar');
            $table->dropColumn('sisa_pembayaran');
        });
    }
};

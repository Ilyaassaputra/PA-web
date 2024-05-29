<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_tagihans', function (Blueprint $table) {
            $table->uuid('batch_id')->after('nominal_tagihan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('data_tagihans', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanKoreksiKonsepDetailTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_koreksi_konsep_detail', function (Blueprint $table) {
            $table->boolean('is_revisi')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_koreksi_konsep_detail', function (Blueprint $table) {
            $table->dropColumn(['is_revisi']);
        });
    }
}

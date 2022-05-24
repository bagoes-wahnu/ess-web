<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanPersetujuanTeknisTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'tanggal_surat']);
        });
    }
}

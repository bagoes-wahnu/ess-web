<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanPersetujuanTeknisTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->unique('nomor_surat');
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
            $table->dropUnique(['nomor_surat']);
        });
    }
}

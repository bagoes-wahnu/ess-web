<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanKoreksiKonsepTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_koreksi_konsep', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dinas');
            $table->dropColumn(['jenis']);

            $table->foreign('id_dinas')->references('id')->on('m_dinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_koreksi_konsep', function (Blueprint $table) {
            $table->dropColumn('id_dinas');
            $table->integer(['jenis']);
        });
    }
}

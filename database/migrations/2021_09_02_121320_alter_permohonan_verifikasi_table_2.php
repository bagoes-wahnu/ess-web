<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanVerifikasiTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_verifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dinas');
            $table->dropColumn(['id_user']);

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
        Schema::table('permohonan_verifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->dropColumn(['id_dinas']);

            $table->foreign('id_user')->references('id')->on('m_user')->onDelete('cascade');
        });
    }
}

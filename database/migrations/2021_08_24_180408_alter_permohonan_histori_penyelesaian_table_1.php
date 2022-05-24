<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanHistoriPenyelesaianTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_histori_penyelesaian', function (Blueprint $table) {
            $table->dropColumn(['deskripsi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_histori_penyelesaian', function (Blueprint $table) {
            $table->text('deskripsi');
        });
    }
}

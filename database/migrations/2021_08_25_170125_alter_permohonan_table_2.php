<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan_histori_penyelesaian']);
            $table->foreign('id_permohonan_histori_penyelesaian')->references('id')->on('permohonan_histori_penyelesaian')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan_histori_penyelesaian']);
            $table->foreign('id_permohonan_histori_penyelesaian')->references('id')->on('permohonan_histori_penyelesaian')->onDelete('cascade');
        });
    }
}

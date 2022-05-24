<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_induk_fisik')->nullable();
            $table->unsignedBigInteger('id_induk_fisik_awal')->nullable();
            $table->integer('permohonan_ke')->nullable()->change();
            $table->integer('permohonan_fisik_ke')->nullable();
            $table->unsignedBigInteger('id_permohonan_fisik_histori_penyelesaian')->nullable();

            $table->foreign('id_induk_fisik')->references('id')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_permohonan_fisik_histori_penyelesaian')->references('id')->on('permohonan_histori_penyelesaian')->onDelete('set null');
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
            $table->integer('permohonan_ke')->nullable(false)->change();
            $table->dropColumn(['id_induk_fisik', 'id_induk_fisik_awal', 'permohonan_fisik_ke', 'id_permohonan_fisik_histori_penyelesaian']);
        });
    }
}

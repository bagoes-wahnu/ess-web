<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanPersyaratanFileTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_persyaratan_file', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ssw')->nullable()->change();
            $table->unsignedBigInteger('id_berkas')->nullable()->change();
            $table->string('nama')->nullable()->change();
            $table->string('path')->nullable()->change();
            $table->float('ukuran')->nullable()->change();
            $table->string('ext')->nullable()->change();
            $table->unique('id_ssw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_persyaratan_file', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ssw')->nullable(false)->change();
            $table->unsignedBigInteger('id_berkas')->nullable(false)->change();
            $table->string('nama')->nullable(false)->change();
            $table->string('path')->nullable(false)->change();
            $table->float('ukuran')->nullable(false)->change();
            $table->string('ext')->nullable(false)->change();
            $table->dropUnique(['id_ssw']);
        });
    }
}

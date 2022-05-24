<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanSswPersyaratanFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_ssw_persyaratan_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_berkas');
            $table->string('nama')->nullable();
            $table->string('path')->nullable();
            $table->float('ukuran')->nullable();
            $table->string('ext')->nullable();
            $table->boolean('is_gambar')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_ssw_persyaratan_file');
    }
}

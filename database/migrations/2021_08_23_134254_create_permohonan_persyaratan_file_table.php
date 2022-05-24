<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanPersyaratanFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_persyaratan_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ssw');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_berkas');
            $table->string('nama');
            $table->string('path');
            $table->float('ukuran');
            $table->string('ext');
            $table->boolean('is_gambar')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_permohonan')->references('id')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_berkas')->references('id')->on('m_berkas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_persyaratan_file');
    }
}

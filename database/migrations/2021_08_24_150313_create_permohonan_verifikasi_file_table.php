<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanVerifikasiFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_verifikasi_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permohonan_verifikasi');
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

            $table->foreign('id_permohonan_verifikasi')->references('id')->on('permohonan_verifikasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_verifikasi_file');
    }
}

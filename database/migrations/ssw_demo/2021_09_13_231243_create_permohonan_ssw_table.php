<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanSswTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_ssw', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_induk')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('nomor_permohonan')->nullable();
            $table->string('nama_subjek')->nullable();
            $table->string('nama_perumahan')->nullable();
            $table->integer('lampiran')->nullable();
            $table->string('perihal')->nullable();
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_kelurahan');
            $table->string('nomor_skrk')->nullable();
            $table->date('tanggal_skrk')->nullable();
            $table->string('nomor_lampiran_gambar')->nullable();
            $table->string('atas_nama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('jabatan_pada_perusahaan')->nullable();
            $table->float('luas_lahan_pengembangan')->nullable();
            $table->float('luas_prasarana_jalan_saluran')->nullable();
            $table->float('luas_sarana_fasilitas_umum')->nullable();
            $table->float('luas_sarana_rth')->nullable();
            $table->integer('status');
            $table->boolean('is_penarikan_psu')->default(false);
            $table->text('alamat_perumahan')->nullable();
            $table->string('jenis_kegiatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_ssw');
    }
}

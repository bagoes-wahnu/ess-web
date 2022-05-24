<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ssw');
            $table->unsignedBigInteger('id_induk')->nullable();
            $table->unsignedBigInteger('id_induk_awal')->nullable();
            $table->integer('permohonan_ke');
            $table->integer('jenis');
            $table->date('tanggal_permohonan');
            $table->string('nomor_permohonan');
            $table->string('nama_subjek');
            $table->string('nama_perumahan');
            $table->integer('lampiran');
            $table->string('perihal');
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->string('nomor_skrk');
            $table->date('tanggal_skrk');
            $table->string('nomor_lampiran_gambar');
            $table->string('atas_nama');
            $table->text('alamat');
            $table->string('nama_perusahaan');
            $table->string('nama_pemohon');
            $table->string('jabatan_pada_perusahaan');
            $table->float('luas_lahan_pengembangan');
            $table->float('luas_prasarana_jalan_saluran');
            $table->float('luas_sarana_fasilitas_umum');
            $table->float('luas_sarana_rth');
            $table->unsignedBigInteger('id_permohonan_histori_penyelesaian')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_induk')->references('id')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_kecamatan')->references('id')->on('m_kecamatan')->onDelete('cascade');
            $table->foreign('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan');
    }
}

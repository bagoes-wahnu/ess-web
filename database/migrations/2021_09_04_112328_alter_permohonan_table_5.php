<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->date('tanggal_permohonan')->nullable()->change();
            $table->string('nomor_permohonan')->nullable()->change();
            $table->string('nama_subjek')->nullable()->change();
            $table->string('nama_perumahan')->nullable()->change();
            $table->integer('lampiran')->nullable()->change();
            $table->string('perihal')->nullable()->change();
            $table->string('nomor_skrk')->nullable()->change();
            $table->date('tanggal_skrk')->nullable()->change();
            $table->string('nomor_lampiran_gambar')->nullable()->change();
            $table->string('atas_nama')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('nama_perusahaan')->nullable()->change();
            $table->string('nama_pemohon')->nullable()->change();
            $table->string('jabatan_pada_perusahaan')->nullable()->change();
            $table->float('luas_lahan_pengembangan')->nullable()->change();
            $table->float('luas_prasarana_jalan_saluran')->nullable()->change();
            $table->float('luas_sarana_fasilitas_umum')->nullable()->change();
            $table->float('luas_sarana_rth')->nullable()->change();
            $table->float('alamat_perumahan')->nullable();
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
            $table->date('tanggal_permohonan')->nullable(false)->change();
            $table->string('nomor_permohonan')->nullable(false)->change();
            $table->string('nama_subjek')->nullable(false)->change();
            $table->string('nama_perumahan')->nullable(false)->change();
            $table->integer('lampiran')->nullable(false)->change();
            $table->string('perihal')->nullable(false)->change();
            $table->string('nomor_skrk')->nullable(false)->change();
            $table->date('tanggal_skrk')->nullable(false)->change();
            $table->string('nomor_lampiran_gambar')->nullable(false)->change();
            $table->string('atas_nama')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->string('nama_perusahaan')->nullable(false)->change();
            $table->string('nama_pemohon')->nullable(false)->change();
            $table->string('jabatan_pada_perusahaan')->nullable(false)->change();
            $table->float('luas_lahan_pengembangan')->nullable(false)->change();
            $table->float('luas_prasarana_jalan_saluran')->nullable(false)->change();
            $table->float('luas_sarana_fasilitas_umum')->nullable(false)->change();
            $table->float('luas_sarana_rth')->nullable(false)->change();
            $table->dropColumn(['alamat_perumahan']);
        });
    }
}

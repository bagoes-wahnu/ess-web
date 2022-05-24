<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanKoreksiKonsepDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_koreksi_konsep_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permohonan_koreksi_konsep');
            $table->unsignedBigInteger('id_berkas_konsep');
            $table->text('catatan');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_permohonan_koreksi_konsep')->references('id')->on('permohonan_koreksi_konsep')->onDelete('cascade');
            $table->foreign('id_berkas_konsep')->references('id')->on('m_berkas_konsep')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_koreksi_konsep');
    }
}

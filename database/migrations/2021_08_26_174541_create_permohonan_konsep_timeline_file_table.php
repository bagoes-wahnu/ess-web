<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanKonsepTimelineFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_konsep_timeline_file', function (Blueprint $table) {
            $table->unsignedBigInteger('id_permohonan_konsep_file')->nullable();
            $table->unsignedBigInteger('id_permohonan_konsep_timeline')->nullable();

            $table->foreign('id_permohonan_konsep_file')->references('id')->on('permohonan_konsep_file')->onDelete('cascade');
            $table->foreign('id_permohonan_konsep_timeline')->references('id')->on('permohonan_konsep_timeline')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_konsep_timeline_file');
    }
}

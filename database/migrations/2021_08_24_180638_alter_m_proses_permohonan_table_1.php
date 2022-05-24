<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMProsesPermohonanTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_proses_permohonan', function (Blueprint $table) {
            $table->integer('jenis');
            $table->dropColumn(['is_pengembalian']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_proses_permohonan', function (Blueprint $table) {
            $table->boolean('is_pengembalian')->default(false);
            $table->dropColumn(['jenis']);
        });
    }
}

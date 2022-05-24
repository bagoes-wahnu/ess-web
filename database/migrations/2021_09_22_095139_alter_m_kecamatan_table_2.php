<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMKecamatanTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_kecamatan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ssw_provinsi')->nullable();
            $table->unsignedBigInteger('id_ssw_kabupaten')->nullable();
            $table->dropUnique(['id_ssw']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_kecamatan', function (Blueprint $table) {
            $table->dropColumn(['id_ssw_provinsi', 'id_ssw_kabupaten']);
            $table->unique('id_ssw');
        });
    }
}

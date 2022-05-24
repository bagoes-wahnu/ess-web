<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMTtdTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_ttd', function (Blueprint $table) {
            $table->string('nama_stempel');
            $table->string('path_stempel');
            $table->float('ukuran_stempel');
            $table->string('ext_stempel');
            $table->boolean('stempel_is_gambar')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_ttd', function (Blueprint $table) {
            $table->dropColumn(['nama_stempel', 'path_stempel', 'ukuran_stempel', 'ext_stempel', 'stempel_is_gambar']);
        });
    }
}

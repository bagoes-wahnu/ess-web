<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanPersetujuanTeknisTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->string('no_bast_admin')->nullable();
            $table->date('tgl_bast_admin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->dropColumn(['no_bast_admin', 'tgl_bast_admin']);
        });
    }
}

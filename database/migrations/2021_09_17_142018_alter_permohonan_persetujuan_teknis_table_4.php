<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanPersetujuanTeknisTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_persetujuan_teknis', function (Blueprint $table) {
            $table->text('catatan')->nullable()->change();
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
            $table->text('catatan')->nullable(false)->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanHistoriPenyelesaianTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_histori_penyelesaian', function (Blueprint $table) {
            $table->integer('jumlah_hari')->default(0)->change();
            $table->boolean('is_pengembalian')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_histori_penyelesaian', function (Blueprint $table) {
            $table->integer('jumlah_hari')->default(null)->change();
            $table->dropColumn(['is_pengembalian']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->boolean('is_bast_admin')->default(false);
            $table->boolean('is_bast_fisik')->default(false);
            $table->dropColumn(['jenis']);
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
            $table->dropColumn(['is_bast_admin', 'is_bast_fisik']);
            $table->integer('jenis');
        });
    }
}

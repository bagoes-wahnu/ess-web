<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMBerkasKonsepTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_berkas_konsep', function (Blueprint $table) {
            $table->text('nama')->change();
            $table->boolean('is_bast_admin')->default(false);
            $table->boolean('is_bast_fisik')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_berkas_konsep', function (Blueprint $table) {
            $table->string('nama')->change();
            $table->dropColumn(['is_bast_admin', 'is_bast_fisik']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMTtdTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_ttd', function (Blueprint $table) {
            $table->string('nama')->nullable()->change();
            $table->string('path')->nullable()->change();
            $table->float('ukuran')->nullable()->change();
            $table->string('ext')->nullable()->change();
            $table->string('nama_stempel')->nullable()->change();
            $table->string('path_stempel')->nullable()->change();
            $table->float('ukuran_stempel')->nullable()->change();
            $table->string('ext_stempel')->nullable()->change();
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
            $table->string('nama')->nullable(false)->change();
            $table->string('path')->nullable(false)->change();
            $table->float('ukuran')->nullable(false)->change();
            $table->string('ext')->nullable(false)->change();
            $table->string('nama_stempel')->nullable(false)->change();
            $table->string('path_stempel')->nullable(false)->change();
            $table->float('ukuran_stempel')->nullable(false)->change();
            $table->string('ext_stempel')->nullable(false)->change();
        });
    }
}

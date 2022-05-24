<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDinasTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_dinas', function (Blueprint $table) {
            $table->string('telepon')->nullable()->change();
             $table->string('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_dinas', function (Blueprint $table) {
            $table->string('telepon')->change();
            $table->string('alamat')->change();
        });
    }
}

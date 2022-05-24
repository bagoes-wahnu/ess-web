<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanEvaluasiSurveyTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_evaluasi_survey', function (Blueprint $table) {
            $table->boolean('is_otomatis')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_evaluasi_survey', function (Blueprint $table) {
            $table->dropColumn(['is_otomatis']);
        });
    }
}

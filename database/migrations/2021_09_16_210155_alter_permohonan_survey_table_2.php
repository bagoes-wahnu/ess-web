<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPermohonanSurveyTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_survey', function (Blueprint $table) {
            $table->text('catatan')->nullable()->change();
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
        Schema::table('permohonan_survey', function (Blueprint $table) {
            $table->text('catatan')->nullable(false)->change();
            $table->dropColumn(['is_otomatis']);
        });
    }
}

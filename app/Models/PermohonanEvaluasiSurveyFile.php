<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanEvaluasiSurveyFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_evaluasi_survey_file';

    protected $fillable = [
        'id_permohonan_evaluasi_survey', 'nama', 'path', 'ukuran', 'ext', 'is_gambar', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_evaluasi_survey()
    {
        return $this->belongsTo(PermohonanEvaluasiSurvey::class, 'id_permohonan_evaluasi_survey', 'id');
    }
}

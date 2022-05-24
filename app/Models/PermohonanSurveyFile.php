<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanSurveyFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_survey_file';

    protected $fillable = [
        'id_permohonan_survey', 'nama', 'path', 'ukuran', 'ext', 'is_gambar', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_survey()
    {
        return $this->belongsTo(PermohonanSurvey::class, 'id_permohonan_survey', 'id');
    }
}

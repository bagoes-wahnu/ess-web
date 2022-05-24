<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanSurvey extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->whereHas('dinas', function($query) {
                    $query->where('status', true);
                });
            });
        });
    }

    protected $table = 'permohonan_survey';

    protected $fillable = [
        'id_permohonan', 'id_dinas', 'catatan', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_survey_file'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id');
    }

    public function permohonan_survey_file()
    {
        return $this->hasMany(PermohonanSurveyFile::class, 'id_permohonan_survey', 'id');
    }
}

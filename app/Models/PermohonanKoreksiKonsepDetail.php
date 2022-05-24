<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanKoreksiKonsepDetail extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->whereHas('berkas_konsep', function($query) {
                    $query->where('status', true);
                });
            });
        });
    }

    protected $table = 'permohonan_koreksi_konsep_detail';

    protected $fillable = [
        'id_permohonan_koreksi_konsep', 'id_berkas_konsep', 'catatan', 'is_revisi',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_koreksi_konsep_detail_file'];

    public function permohonan_koreksi_konsep()
    {
        return $this->belongsTo(PermohonanKoreksiKonsep::class, 'id_permohonan_koreksi_konsep', 'id');
    }

    public function berkas_konsep()
    {
        return $this->belongsTo(BerkasKonsep::class, 'id_berkas_konsep', 'id');
    }

    public function permohonan_koreksi_konsep_detail_file()
    {
        return $this->hasMany(PermohonanKoreksiKonsepDetailFile::class, 'id_permohonan_koreksi_konsep_detail', 'id');
    }
}

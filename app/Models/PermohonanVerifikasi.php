<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanVerifikasi extends Model
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

    protected $table = 'permohonan_verifikasi';

    protected $fillable = [
        'id_permohonan', 'id_dinas', 'catatan', 'status', 'is_otomatis', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_verifikasi_file'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id');
    }

    public function permohonan_verifikasi_file()
    {
        return $this->hasMany(PermohonanVerifikasiFile::class, 'id_permohonan_verifikasi', 'id');
    }
}

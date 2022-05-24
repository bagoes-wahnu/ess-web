<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanHistoriPenyelesaian extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('status', true);
                });
            });
        });
    }

    protected $table = 'permohonan_histori_penyelesaian';

    protected $fillable = [
        'id_permohonan', 'id_proses_permohonan', 'jumlah_hari', 'is_pengembalian', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function proses_permohonan()
    {
        return $this->belongsTo(ProsesPermohonan::class, 'id_proses_permohonan', 'id');
    }
}

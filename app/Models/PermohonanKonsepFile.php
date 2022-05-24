<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanKonsepFile extends Model
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

    protected $table = 'permohonan_konsep_file';

    protected $fillable = [
        'id_permohonan', 'id_berkas_konsep', 'nama', 'path', 'ukuran', 'ext', 'is_gambar',
        'is_revisi', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function berkas_konsep()
    {
        return $this->belongsTo(BerkasKonsep::class, 'id_berkas_konsep', 'id');
    }

    public function permohonan_konsep_timeline()
    {
        return $this->belongsToMany(PermohonanKonsepTimeline::class, 'permohonan_konsep_timeline_file', 'id_permohonan_konsep_file', 'id_permohonan_konsep_timeline');
    }
}

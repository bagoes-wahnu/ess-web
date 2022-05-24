<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanPersyaratanFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->whereHas('berkas', function($query) {
                    $query->where('status', true);
                });
            });
        });
    }

    protected $table = 'permohonan_persyaratan_file';

    protected $fillable = [
        'id_permohonan', 'id_berkas', 'nama', 'path', 'ext', 'ukuran', 'is_gambar',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }
    
    public function berkas()
    {
        return $this->belongsTo(Berkas::class, 'id_berkas', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanKonsepTimeline extends Model
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

    protected $table = 'permohonan_konsep_timeline';

    protected $fillable = [
        'id_permohonan', 'id_berkas_konsep', 'deskripsi', 'is_revisi', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function berkas_konsep()
    {
        return $this->belongsTo(BerkasKonsep::class, 'id_berkas_konsep', 'id');
    }

    public function permohonan_konsep_file()
    {
        return $this->belongsToMany(PermohonanKonsepFile::class, 'permohonan_konsep_timeline_file', 'id_permohonan_konsep_timeline', 'id_permohonan_konsep_file');
    }

    public static function storeTimeline($id_permohonan, $id_berkas_konsep, $is_revisi, $file, $status, $jenis_bast)
    {
        $deskripsi = null;

        if($status == 1) $deskripsi = 'DPRKPCKTR (Rayon) mengunggah berkas baru';
        elseif($status == 2) $deskripsi = 'DPRKPCKTR (Rayon) menghapus berkas';

        $permohonanKonsepTimeline = new PermohonanKonsepTimeline();
        $permohonanKonsepTimeline->id_permohonan = $id_permohonan;
        $permohonanKonsepTimeline->id_berkas_konsep = $id_berkas_konsep;
        $permohonanKonsepTimeline->deskripsi = $deskripsi;
        $permohonanKonsepTimeline->is_revisi = $is_revisi;
        $permohonanKonsepTimeline->jenis_bast = $jenis_bast;
        $permohonanKonsepTimeline->save();
        $permohonanKonsepTimeline->permohonan_konsep_file()->attach($file);
    }
}

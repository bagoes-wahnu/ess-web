<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanPersetujuanTeknis extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_persetujuan_teknis';

    protected $fillable = [
        'id_permohonan', 'nomor_surat', 'tanggal_surat', 'no_bast_admin', 'tgl_bast_admin', 'catatan', 'status', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_persetujuan_teknis_file', 'permohonan_persetujuan_teknis_timeline'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function permohonan_persetujuan_teknis_file()
    {
        return $this->hasMany(PermohonanPersetujuanTeknisFile::class, 'id_permohonan_persetujuan_teknis', 'id');
    }

    public function permohonan_persetujuan_teknis_timeline()
    {
        return $this->hasMany(PermohonanPersetujuanTeknisTimeline::class, 'id_permohonan_persetujuan_teknis', 'id');
    }
}

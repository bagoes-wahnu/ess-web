<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class Permohonan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            if(auth('api')->check() == true)
            {
                $builder->where(function($query) {
                    $query->whereHas('kecamatan', function($query) {
                        $query->where('status', true);
                    });
                    $query->whereHas('kelurahan', function($query) {
                        $query->where('status', true);
                    });
                });
            }
        });
    }

    protected $table = 'permohonan';

    protected $fillable = [
        'id_ssw',
        'id_induk',
        'id_induk_awal',
        'permohonan_ke',
        'id_induk_fisik',
        'id_induk_fisik_awal',
        'permohonan_fisik_ke',
        'is_bast_admin',
        'is_bast_fisik',
        'tanggal_permohonan',
        'nomor_permohonan',
        'nama_subjek',
        'nama_perumahan',
        'lampiran',
        'perihal',
        'id_kecamatan',
        'id_kelurahan',
        'nomor_skrk',
        'tanggal_skrk',
        'nomor_lampiran_gambar',
        'atas_nama',
        'alamat',
        'alamat_perumahan',
        'nama_perusahaan',
        'nama_pemohon',
        'jabatan_pada_perusahaan',
        'luas_lahan_pengembangan',
        'luas_prasarana_jalan_saluran',
        'luas_sarana_fasilitas_umum',
        'luas_sarana_rth',
        'jenis_kegiatan',
        'id_permohonan_histori_penyelesaian',
        'id_permohonan_fisik_histori_penyelesaian',
        'created_by', 
        'updated_by', 
        'deleted_by',
    ];

    protected $softCascade = ['permohonan_persyaratan_file', 'permohonan_timeline',
    'permohonan_histori_penyelesaian', 'permohonan_verifikasi', 'permohonan_berita_acara',
    'permohonan_konsep_file', 'permohonan_konsep_timeline', 'permohonan_koreksi_konsep',
    'permohonan_persetujuan_teknis', 'permohonan_survey', 'permohonan_evaluasi_survey'];

    public function permohonan_induk()
    {
        return $this->belongsTo(Permohonan::class, 'id_induk', 'id');
    }

    public function permohonan_fisik_induk()
    {
        return $this->belongsTo(Permohonan::class, 'id_induk_fisik', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan', 'id');
    }

    public function permohonan_persyaratan_file()
    {
        return $this->hasMany(PermohonanPersyaratanFile::class, 'id_permohonan', 'id');
    }

    public function permohonan_timeline()
    {
        return $this->hasMany(PermohonanTimeline::class, 'id_permohonan', 'id');
    }

    public function permohonan_histori_penyelesaian()
    {
        return $this->hasMany(PermohonanHistoriPenyelesaian::class, 'id_permohonan', 'id');
    }

    public function permohonan_histori_penyelesaian_last()
    {
        return $this->belongsTo(PermohonanHistoriPenyelesaian::class, 'id_permohonan_histori_penyelesaian', 'id');
    }

    public function permohonan_fisik_histori_penyelesaian_last()
    {
        return $this->belongsTo(PermohonanHistoriPenyelesaian::class, 'id_permohonan_fisik_histori_penyelesaian', 'id');
    }

    public function permohonan_verifikasi()
    {
        return $this->hasMany(PermohonanVerifikasi::class, 'id_permohonan', 'id');
    }

    public function permohonan_berita_acara()
    {
        return $this->hasMany(PermohonanBeritaAcara::class, 'id_permohonan', 'id');
    }

    public function permohonan_konsep_file()
    {
        return $this->hasMany(PermohonanKonsepFile::class, 'id_permohonan', 'id');
    }

    public function permohonan_konsep_timeline()
    {
        return $this->hasMany(PermohonanKonsepTimeline::class, 'id_permohonan', 'id');
    }

    public function permohonan_koreksi_konsep()
    {
        return $this->hasMany(PermohonanKoreksiKonsep::class, 'id_permohonan', 'id');
    }

    public function permohonan_persetujuan_teknis()
    {
        return $this->hasOne(PermohonanPersetujuanTeknis::class, 'id_permohonan', 'id');
    }

    public function permohonan_survey()
    {
        return $this->hasMany(PermohonanSurvey::class, 'id_permohonan', 'id');
    }

    public function permohonan_evaluasi_survey()
    {
        return $this->hasMany(PermohonanEvaluasiSurvey::class, 'id_permohonan', 'id');
    }
}

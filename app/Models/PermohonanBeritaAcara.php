<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanBeritaAcara extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_berita_acara';

    protected $fillable = [
        'id_permohonan', 'catatan', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_berita_acara_file'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function permohonan_berita_acara_file()
    {
        return $this->hasMany(PermohonanBeritaAcaraFile::class, 'id_permohonan_berita_acara', 'id');
    }
}

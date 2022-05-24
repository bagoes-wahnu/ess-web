<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanBeritaAcaraFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_berita_acara_file';

    protected $fillable = [
        'id_permohonan_berita_acara', 'nama', 'path', 'ukuran', 'ext', 'is_gambar', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_berita_acara()
    {
        return $this->belongsTo(PermohonanBeritaAcara::class, 'id_permohonan_berita_acara', 'id');
    }
}

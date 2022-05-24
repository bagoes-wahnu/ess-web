<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanVerifikasiFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_verifikasi_file';

    protected $fillable = [
        'id_permohonan_verifikasi', 'nama', 'path', 'ukuran', 'ext', 'is_gambar', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_verifikasi()
    {
        return $this->belongsTo(PermohonanVerifikasi::class, 'id_permohonan_verifikasi', 'id');
    }
}

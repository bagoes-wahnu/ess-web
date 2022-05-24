<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanPersetujuanTeknisFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_persetujuan_teknis_file';

    protected $fillable = [
        'id_permohonan_persetujuan_teknis', 'nama', 'path', 'ukuran', 'ext', 'is_gambar',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_persetujuan_teknis()
    {
        return $this->belongsTo(PermohonanPersetujuanTeknis::class, 'id_permohonan_persetujuan_teknis', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanKoreksiKonsepDetailFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_koreksi_konsep_detail_file';

    protected $fillable = [
        'id_permohonan_koreksi_konsep_detail', 'nama', 'path', 'ukuran', 'ext', 'is_gambar',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_koreksi_konsep_detail()
    {
        return $this->belongsTo(PermohonanKoreksiKonsepDetail::class, 'id_permohonan_koreksi_konsep_detail', 'id');
    }
}

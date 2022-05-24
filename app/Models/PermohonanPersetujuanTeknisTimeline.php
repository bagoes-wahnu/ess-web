<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanPersetujuanTeknisTimeline extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_persetujuan_teknis_timeline';

    protected $fillable = [
        'id_permohonan_persetujuan_teknis', 'deskripsi', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan_persetujuan_teknis()
    {
        return $this->belongsTo(PermohonanPersetujuanTeknis::class, 'id_permohonan_persetujuan_teknis', 'id');
    }

    public static function storeTimeline($id_permohonan_persetujuan_teknis, $status)
    {
        $role = auth('api')->user()->role;

        $deskripsi = null;

        if($status == 1) $deskripsi = 'DPRKPCKTR (Rayon) meneruskan persetujuan teknis baru ke Kasie';
        elseif($status == 2) $deskripsi = "DPRKPCKTR ({$role->nama}) menyetujui persetujuan teknis";

        $permohonanPersetujuanTeknisTimeline = new PermohonanPersetujuanTeknisTimeline();
        $permohonanPersetujuanTeknisTimeline->id_permohonan_persetujuan_teknis = $id_permohonan_persetujuan_teknis;
        $permohonanPersetujuanTeknisTimeline->deskripsi = $deskripsi;
        $permohonanPersetujuanTeknisTimeline->save();
    }
}

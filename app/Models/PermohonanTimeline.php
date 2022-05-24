<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class PermohonanTimeline extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'permohonan_timeline';

    protected $fillable = [
        'id_permohonan', 'deskripsi', 'status', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public static function storeTimeline($id_permohonan, $status, $jenis_bast)
    {
        $deskripsi = null;

        if($jenis_bast == 1)
        {
            if($status == 1) $deskripsi = 'Permohonan sedang diperiksa oleh Tim Verifikasi';
            elseif($status == 2) $deskripsi = 'Sistem mengembalikan permohonan ke pemohon dikarenakan terdapat salah satu Tim Verifikasi yang memilih mengembalikan permohonan';
            elseif($status == 3) $deskripsi = 'Sistem melanjutkan proses ke DPRKPCKTR (Rayon) dikarenakan semua Tim Verifikasi mengapprove permohonan';
            elseif($status == 4) $deskripsi = 'DPRKPCKTR (Rayon) telah menyusun konsep';
            elseif($status == 5) $deskripsi = 'Sistem mengembalikan konsep ke DPRKPCKTR (Rayon) untuk di revisi dikarenakan terdapat Bagian Hukum / DPBT yang memilih menolak konsep';
            elseif($status == 6) $deskripsi = 'Sistem melanjutkan proses ke DPRKPCKTR (Rayon) dikarenakan Bagian Hukum / DPBT telah mengapprove konsep';
            elseif($status == 7) $deskripsi = 'DPRKPCKTR (Rayon) telah merevisi konsep';
            elseif($status == 8) $deskripsi = 'DPRKPCKTR (Rayon) telah membuat persetujuan teknis dan menunggu approve dari DPRKPCKTR (Kasie, Kabid, Sekretaris, Kadis)';
            elseif($status == 9) $deskripsi = 'Sistem melanjutkan proses ke DPMPTSP';
        }
        elseif($jenis_bast == 2)
        {
            if($status == 1) $deskripsi = 'Permohonan sedang diperiksa oleh Tim Verifikasi';
            elseif($status == 2) $deskripsi = 'Sistem melanjutkan proses ke DPUBMP, DKRTH, DPBT dikarenakan semua Tim Verifikasi mengapprove permohonan';
            elseif($status == 3) $deskripsi = 'Sistem melanjutkan proses ke Tim Verifikasi dikarenakan DPUBMP, DKRTH, DPBT telah menyusun survey';
            elseif($status == 4) $deskripsi = 'Sistem mengembalikan permohonan ke pemohon dikarenakan terdapat salah satu Tim Verifikasi yang memilih menolak hasil survey';
            elseif($status == 5) $deskripsi = 'Sistem melanjutkan proses ke DPRKPCKTR (Rayon) dikarenakan semua Tim Verifikasi mengapprove hasil survey';
            elseif($status == 6) $deskripsi = 'DPRKPCKTR (Rayon) telah menyusun konsep';
            elseif($status == 7) $deskripsi = 'Sistem mengembalikan konsep ke DPRKPCKTR (Rayon) untuk di revisi dikarenakan salah satu Tim Verifikasi memilih menolak konsep';
            elseif($status == 8) $deskripsi = 'Sistem melanjutkan proses ke DPRKPCKTR (Rayon) dikarenakan semua Tim Verifikasi mengapprove konsep';
            elseif($status == 9) $deskripsi = 'DPRKPCKTR (Rayon) telah merevisi konsep';
            elseif($status == 10) $deskripsi = 'DPRKPCKTR (Rayon) telah membuat persetujuan teknis dan menunggu approve dari DPRKPCKTR (Kasie, Kabid, Sekretaris, Kadis)';
            elseif($status == 11) $deskripsi = 'Sistem melanjutkan proses ke DPMPTSP';
        }

        $permohonanTimeline = new PermohonanTImeline();
        $permohonanTimeline->id_permohonan = $id_permohonan;
        $permohonanTimeline->status = $status;
        $permohonanTimeline->deskripsi = $deskripsi;
        $permohonanTimeline->jenis_bast = $jenis_bast;
        $permohonanTimeline->save();
    }
}

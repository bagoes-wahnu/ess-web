<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Helpers\HelperPublic;

class PermohonanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($request->custom_resource == true)
        {
            $result = $this->customResource($request->role, $request->jenis_bast);
            return $result;
        }

        $result = [
            'id' => $this->id,
            'id_ssw' => $this->id_ssw,
            'id_induk_awal' => $this->id_induk_awal,
            'permohonan_ke' => $this->permohonan_ke,
            'id_induk_fisik_awal' => $this->id_induk_fisik_awal,
            'permohonan_fisik_ke' => $this->permohonan_fisik_ke,
            'is_bast_admin' => $this->is_bast_admin,
            'is_bast_fisik' => $this->is_bast_fisik,
            'tanggal_permohonan' =>  $this->tanggal_permohonan,
            'nomor_permohonan' =>  $this->nomor_permohonan,
            'nama_subjek' =>  $this->nama_subjek,
            'nama_perumahan' =>  $this->nama_perumahan,
            'lampiran' =>  $this->lampiran,
            'perihal' =>  $this->perihal,
            'nomor_skrk' =>  $this->nomor_skrk,
            'tanggal_skrk' =>  $this->tanggal_skrk,
            'nomor_lampiran_gambar' =>  $this->nomor_lampiran_gambar,
            'atas_nama' =>  $this->atas_nama,
            'alamat' =>  $this->alamat,
            'alamat_perumahan' => $this->alamat_perumahan,
            'nama_perusahaan' =>  $this->nama_perusahaan,
            'nama_pemohon' =>  $this->nama_pemohon,
            'jabatan_pada_perusahaan' =>  $this->jabatan_pada_perusahaan,
            'luas_lahan_pengembangan' =>  $this->luas_lahan_pengembangan,
            'luas_prasarana_jalan_saluran' =>  $this->luas_prasarana_jalan_saluran,
            'luas_sarana_fasilitas_umum' =>  $this->luas_sarana_fasilitas_umum,
            'luas_sarana_rth' =>  $this->luas_sarana_rth,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_induk' => new PermohonanResource($this->whenLoaded('permohonan_induk')),
            'permohonan_fisik_induk' => new PermohonanResource($this->whenLoaded('permohonan_fisik_induk')),
            'kecamatan' => new KecamatanResource($this->whenLoaded('kecamatan')),
            'kelurahan' => new KelurahanResource($this->whenLoaded('kelurahan')),
            'permohonan_persyaratan_file' => PermohonanPersyaratanFileResource::collection($this->whenLoaded('permohonan_persyaratan_file')),
            'permohonan_timeline' => PermohonanTimelineResource::collection($this->whenLoaded('permohonan_timeline')),
            'permohonan_histori_penyelesaian' => PermohonanHistoriPenyelesaianResource::collection($this->whenLoaded('permohonan_histori_penyelesaian')),
            'permohonan_histori_penyelesaian_last' => new PermohonanHistoriPenyelesaianResource($this->whenLoaded('permohonan_histori_penyelesaian_last')),
            'permohonan_fisik_histori_penyelesaian_last' => new PermohonanHistoriPenyelesaianResource($this->whenLoaded('permohonan_fisik_histori_penyelesaian_last')),
            'permohonan_verifikasi' => PermohonanVerifikasiResource::collection($this->whenLoaded('permohonan_verifikasi')),
            'permohonan_berita_acara' => PermohonanBeritaAcaraResource::collection($this->whenLoaded('permohonan_berita_acara')),
            'permohonan_konsep_file' => PermohonanKonsepFileResource::collection($this->whenLoaded('permohonan_konsep_file')),
            'permohonan_konsep_timeline' => PermohonanKonsepTimelineResource::collection($this->whenLoaded('permohonan_konsep_timeline')),
            'permohonan_koreksi_konsep' => PermohonanKoreksiKonsepResource::collection($this->whenLoaded('permohonan_koreksi_konsep')),
            'permohonan_persetujuan_teknis' => new PermohonanPersetujuanTeknisResource($this->whenLoaded('permohonan_persetujuan_teknis')),
            'permohonan_survey' => PermohonanSurveyResource::collection($this->whenLoaded('permohonan_survey')),
            'permohonan_evaluasi_survey' => PermohonanSurveyFileResource::collection($this->whenLoaded('permohonan_evaluasi_survey'))
        ];

        return $result;
    }

    private function customResource($role, $jenis_bast)
    {
        $status = [
            'jenis' => null,
            'jenis_text' => null,
            'deskripsi' => null,
            'proses_verifikasi_button' => false,
            'proses_berita_acara_button' => ($role->id == 6) ? true : false,
            'proses_menyusun_survey_button' => false,
            'proses_evaluasi_survey_button' => false,
            'proses_menyusun_konsep_button' => false,
            'proses_koreksi_konsep_button' => false,
            'proses_revisi_konsep_button' => false,
            'proses_persetujuan_teknis_button' => false,
            'proses_persetujuan_teknis_atasan_button' => false,
            'proses_cetak_persetujuan_teknis_button' => false
        ];

        $permohonanHistLast = ($jenis_bast == 1) ? $this->permohonan_histori_penyelesaian_last : $this->permohonan_fisik_histori_penyelesaian_last;
        $prosesPermohonan = $permohonanHistLast->proses_permohonan;
        $permohonanPersetujuanTeknis = $this->permohonan_persetujuan_teknis;

        if(in_array($prosesPermohonan->id, [2, 9]))
        {
            if($permohonanHistLast->is_pengembalian == true)
            {
                $status['jenis'] = 3;
                $status['jenis_text'] = 'Dikembalikan';
                $status['deskripsi'] = 'Menunggu revisi oleh pemohon';
            }
            else
            {
                $status['jenis'] = 1;
                $status['jenis_text'] = 'Diproses';
                $status['deskripsi'] = 'Diperiksa oleh tim verifikasi';

                if(in_array($role->id, HelperPublic::roleAsVerificator()))
                {
                    $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari anggota lainnya';

                    if(empty($this->permohonan_verifikasi->all()))
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_verifikasi_button'] = true;
                    }
                }
            }
        }
        elseif($prosesPermohonan->id == 10)
        {
            $status['jenis'] = 2;
            $status['jenis_text'] = 'Menyusun Survey';
            $status['deskripsi'] = 'Menunggu hasil survey oleh DPUBMP, DKRTH, DPBT';

            if(in_array($role->id, HelperPublic::roleAsComposeSurveyFisik()))
            {
                $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari anggota lainnya';
                
                if(empty($this->permohonan_survey->all()))
                {
                    $status['deskripsi'] = 'Perlu anda proses';
                    $status['proses_menyusun_survey_button'] = true;
                }
            }
        }
        elseif($prosesPermohonan->id == 11)
        {
            if($permohonanHistLast->is_pengembalian == true)
            {
                $status['jenis'] = 3;
                $status['jenis_text'] = 'Dikembalikan';
                $status['deskripsi'] = 'Menunggu revisi oleh pemohon';
            }
            else
            {
                $status['jenis'] = 2;
                $status['jenis_text'] = 'Evaluasi Hasil Survey';
                $status['deskripsi'] = 'Menunggu evaluasi hasil survey oleh Tim Verifikasi';

                if(in_array($role->id, HelperPublic::roleAsVerificator()))
                {
                    $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari anggota lainnya';
                    
                    if(empty($this->permohonan_evaluasi_survey->all()))
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_evaluasi_survey_button'] = true;
                    }
                }
            }
        }
        elseif(in_array($prosesPermohonan->id, [3, 12]))
        {
            $status['jenis'] = 2;
            $status['jenis_text'] = 'Menyusun Konsep';
            $status['deskripsi'] = 'Menunggu konsep oleh DPRKPCKTR';

            if($role->id == 6)
            {
                $status['deskripsi'] = 'Perlu anda proses';
                $status['proses_menyusun_konsep_button'] = true;
            }
        }
        elseif(in_array($prosesPermohonan->id, [4, 13]))
        {
            $status['jenis'] = 4;
            $status['jenis_text'] = 'Koreksi Konsep';
            $status['deskripsi'] = 'Menunggu koreksi oleh DPBT & Bagian Hukum';

            if($jenis_bast == 1)
            {
                if(in_array($role->id, HelperPublic::roleAsApproveAndCorrectionConceptAdmin()))
                {
                    $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari anggota lainnya';
                
                    if(empty($this->permohonan_koreksi_konsep->all()))
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_koreksi_konsep_button'] = true;
                    }
                }
            }
            elseif($jenis_bast == 2)
            {
                if(in_array($role->id, HelperPublic::roleAsVerificator()))
                {
                    $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari anggota lainnya';
                
                    if(empty($this->permohonan_koreksi_konsep->all()))
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_koreksi_konsep_button'] = true;
                    }
                }
            }
        }
        elseif(in_array($prosesPermohonan->id, [5, 14]))
        {
            $status['jenis'] = 5;
            $status['jenis_text'] = 'Revisi Konsep';
            $status['deskripsi'] = 'Menunggu revisi konsep oleh DPRKPCKTR';

            if($role->id == 6)
            {
                $status['deskripsi'] = 'Perlu anda proses';
                $status['proses_revisi_konsep_button'] = true;
            }
        }
        elseif(in_array($prosesPermohonan->id, [6, 15]))
        {
            $status['jenis'] = 6;
            $status['jenis_text'] = 'Persetujuan Teknis';
            $status['deskripsi'] = 'Menunggu persetujuan teknis oleh DPRKPCKTR';

            if($role->id == 6)
            {
                $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari atasan';

                if(empty($permohonanPersetujuanTeknis))
                {
                    $status['deskripsi'] = 'Perlu anda proses';
                    $status['proses_persetujuan_teknis_button'] = true;
                }
                else
                {
                    $status['proses_cetak_persetujuan_teknis_button'] = true;
                }
            }
            elseif(in_array($role->id, HelperPublic::roleAsHeadOfCKTR()))
            {
                $status['deskripsi'] = 'Sudah anda proses dan menunggu respon dari atasan';

                if($role->id == 2)
                {
                    if($permohonanPersetujuanTeknis->status == 1)
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_persetujuan_teknis_atasan_button'] = true;
                        $status['proses_cetak_persetujuan_teknis_button'] = true;
                    }
                }
                if($role->id == 3)
                {
                    if($permohonanPersetujuanTeknis->status == 2)
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_persetujuan_teknis_atasan_button'] = true;
                        $status['proses_cetak_persetujuan_teknis_button'] = true;
                    }
                }
                if($role->id == 4)
                {
                    if($permohonanPersetujuanTeknis->status == 3)
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_persetujuan_teknis_atasan_button'] = true;
                        $status['proses_cetak_persetujuan_teknis_button'] = true;
                    }
                }
                if($role->id == 5)
                {
                    if($permohonanPersetujuanTeknis->status == 4)
                    {
                        $status['deskripsi'] = 'Perlu anda proses';
                        $status['proses_persetujuan_teknis_atasan_button'] = true;
                        $status['proses_cetak_persetujuan_teknis_button'] = true;
                    }
                }
            }
        }
        elseif(in_array($prosesPermohonan->id, [7, 16]))
        {
            $status['jenis'] = 7;
            $status['jenis_text'] = 'Selesai';
            $status['deskripsi'] = 'Telah diteruskan ke DPMPTSP';

            if($role->id == 6 || in_array($role->id, HelperPublic::roleAsHeadOfCKTR()))
            {
                $status['proses_cetak_persetujuan_teknis_button'] = true;
            }
        }

        $jumlahHari = $permohonanHistLast->created_at->diffInDays(Carbon::now());
        $isTerlambat = ($jumlahHari <= $prosesPermohonan->batas_waktu) ? false : true;

        $result = [
            'id' => $this->id,
            'id_ssw' => $this->id_ssw,
            'id_induk_awal' => $this->id_induk_awal,
            'permohonan_ke' => $this->permohonan_ke,
            'id_induk_fisik_awal' => $this->id_induk_fisik_awal,
            'permohonan_fisik_ke' => $this->permohonan_fisik_ke,
            'is_bast_admin' => $this->is_bast_admin,
            'is_bast_fisik' => $this->is_bast_fisik,
            'tanggal_permohonan' =>  $this->tanggal_permohonan,
            'nomor_permohonan' =>  $this->nomor_permohonan,
            'nama_subjek' =>  $this->nama_subjek,
            'nama_perumahan' =>  $this->nama_perumahan,
            'lampiran' =>  $this->lampiran,
            'perihal' =>  $this->perihal,
            'nomor_skrk' =>  $this->nomor_skrk,
            'tanggal_skrk' =>  $this->tanggal_skrk,
            'nomor_lampiran_gambar' =>  $this->nomor_lampiran_gambar,
            'atas_nama' =>  $this->atas_nama,
            'alamat' =>  $this->alamat,
            'alamat_perumahan' => $this->alamat_perumahan,
            'nama_perusahaan' =>  $this->nama_perusahaan,
            'nama_pemohon' =>  $this->nama_pemohon,
            'jabatan_pada_perusahaan' =>  $this->jabatan_pada_perusahaan,
            'luas_lahan_pengembangan' =>  $this->luas_lahan_pengembangan,
            'luas_prasarana_jalan_saluran' =>  $this->luas_prasarana_jalan_saluran,
            'luas_sarana_fasilitas_umum' =>  $this->luas_sarana_fasilitas_umum,
            'luas_sarana_rth' =>  $this->luas_sarana_rth,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'kecamatan' => new KecamatanResource($this->whenLoaded('kecamatan')),
            'kelurahan' => new KelurahanResource($this->whenLoaded('kelurahan')),
            'jumlah_hari' => $jumlahHari,
            'is_terlambat' => $isTerlambat,
            'status' => $status
        ];

        return $result;
    }
}

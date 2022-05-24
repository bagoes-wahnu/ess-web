<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\ProsesPermohonan;

class ProsesPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try
        {
            $data = [
                //BAST Admin
                [
                    'id' => 1,
                    'nama' => 'DPMPTSP Memeriksa Persyaratan',
                    'batas_waktu' => 1,
                    'jenis' => 1
                ],
                [
                    'id' => 2,
                    'nama' => 'Memeriksa Berkas Permohonan Rekomendasi BAST Administrasi PSU & Rapat Tim Verifikasi (Penyampaian Saran dan Masukan)',
                    'batas_waktu' => 4,
                    'jenis' => 1
                ],
                [
                    'id' => 3,
                    'nama' => 'Menyusun Konsep BAST Administrasi PSU, Perjanjian dan Kerjasama',
                    'batas_waktu' => 3,
                    'jenis' => 1
                ],
                [
                    'id' => 4,
                    'nama' => 'Koreksi Konsep',
                    'batas_waktu' => 2,
                    'jenis' => 1
                ],
                [
                    'id' => 5,
                    'nama' => 'Merevisi Konsep BAST Administrasi PSU, Perjanjian dan Kerjasama',
                    'batas_waktu' => 1,
                    'jenis' => 1
                ],
                [
                    'id' => 6,
                    'nama' => 'Menyampaikan Persetujuan Teknis Kepada DPMPTSP',
                    'batas_waktu' => 1,
                    'jenis' => 1
                ],
                [
                    'id' => 7,
                    'nama' => 'Menyampaikan Rekomendasi BAST Administrasi PSU Kepada Pemohon',
                    'batas_waktu' => 1,
                    'jenis' => 1
                ],
    
                //BAST Fisik
                [
                    'id' => 8,
                    'nama' => 'DPMPTSP Memeriksa Persyaratan',
                    'batas_waktu' => 1,
                    'jenis' => 2
                ],
                [
                    'id' => 9,
                    'nama' => 'Memeriksa Berkas Permohonan Rekomendasi BAST Fisik PSU & Rapat Tim Verifikasi (Penyampaian Saran dan Masukan)',
                    'batas_waktu' => 4,
                    'jenis' => 2
                ],
                [
                    'id' => 10,
                    'nama' => 'Menyampaikan Hasil Survey Kepada DPRKPCKTR',
                    'batas_waktu' => 7,
                    'jenis' => 2
                ],
                [
                    'id' => 11,
                    'nama' => 'Rapat Tim Verifikasi (Evaluasi Hasil Survey)',
                    'batas_waktu' => 1,
                    'jenis' => 2
                ],
                [
                    'id' => 12,
                    'nama' => 'Menyusun Konsep BA Verifikasi dan BAST Fisik',
                    'batas_waktu' => 3,
                    'jenis' => 2
                ],
                [
                    'id' => 13,
                    'nama' => 'Koreksi Konsep',
                    'batas_waktu' => 3,
                    'jenis' => 2
                ],
                [
                    'id' => 14,
                    'nama' => 'Merevisi Konsep BA Verifikasi dan BAST Fisik',
                    'batas_waktu' => 1,
                    'jenis' => 2
                ],
                [
                    'id' => 15,
                    'nama' => 'Menyampaikan Persetujuan Teknis Kepada DPMPTSP',
                    'batas_waktu' => 1,
                    'jenis' => 2
                ],
                [
                    'id' => 16,
                    'nama' => 'Menyampaikan Rekomendasi BAST Fisik PSU Kepada Pemohon',
                    'batas_waktu' => 1,
                    'jenis' => 2
                ]
            ];
    
            foreach ($data as $key => $value) {
                $prosesPermohonan = ProsesPermohonan::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($prosesPermohonan))
                {
                    $prosesPermohonan = new ProsesPermohonan();
                }
    
                $prosesPermohonan->id = $value['id'];
                $prosesPermohonan->nama = $value['nama'];
                $prosesPermohonan->batas_waktu = $value['batas_waktu'];
                $prosesPermohonan->jenis = $value['jenis'];
                $prosesPermohonan->save();
            }
            
            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
			echo $ex->getMessage();
        }
    }
}

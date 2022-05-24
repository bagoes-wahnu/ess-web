<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Berkas;

class BerkasSeeder extends Seeder
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
                [
                    'id' => 1,
                    'nama' => 'Fotokopi kartu tanda penduduk (KTP) pemohon yang masih berlaku',
                    'urutan' => 1,
                    'id_ssw' => 5,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 2,
                    'nama' => 'Fotokopi akta pendirian badan usaha / badan hukum penyelenggara perumahan / pemukiman dan / atau perubahannya yang telah mendapat pengesahan dari pejabat yang berwenang',
                    'urutan' => 2,
                    'id_ssw' => 354,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 3,
                    'nama' => 'Fotokopi sertifikat / bukti penguasaan tanah dan / bangunan tempat usaha yang telah disahkan oleh pejabat yang berwenang',
                    'urutan' => 3,
                    'id_ssw' => 318,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 4,
                    'nama' => 'Rincian spesifikasi, jenis, jumlah dan ukuran obyek yang akan diserahkan sesuai dengan standar teknis yang telah ditetapkan',
                    'urutan' => 4,
                    'id_ssw' => 325,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 5,
                    'nama' => 'Fotokopi surat pemberitahuan pajak terutang pajak bumi dan bangunan (SPPT PBB) dan tanda lunas pajak bumi dan bangunan (PBB) tahun terakhir sesuai ketentuan yang berlaku',
                    'urutan' => 5,
                    'id_ssw' => 30,
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 6,
                    'nama' => 'Fotokopi sertifikat tanah atas nama pengembang yang peruntukannya sebagai prasarana, sarana dan utilitas yang akan diserahkan kepada pemerintah daerah',
                    'urutan' => 6,
                    'id_ssw' => 488,
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 7,
                    'nama' => 'Daftar dan gambar rencana tapak (site plan, zoning dan lain-lain) yang menjelaskan lokasi, jenis dan ukuran prasarana',
                    'urutan' => 7,
                    'id_ssw' => 641,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 8,
                    'nama' => 'Daftar dan gambar rencana tapak (site plan, zoning dan lain-lain) yang menjelaskan lokasi, jenis dan ukuran prasarana, sarana dan ulititas yaga kan diserahkan kepada pemeritah daerah',
                    'urutan' => 8,
                    'id_ssw' => 641,
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 9,
                    'nama' => 'Jadwal / waktu penyelesaian pembangunan, masa pemeliharaan dan serah terima fisik prasarana, sarana dan utilitas',
                    'urutan' => 9,
                    'id_ssw' => 554,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 10,
                    'nama' => 'Fotokopi berita acara serah terima administrasi',
                    'urutan' => 10,
                    'id_ssw' => 554,
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 11,
                    'nama' => 'Bukti setor / bukti pembayaran kompensasi berupa uang sebagai pengganti penyediaan tempat pemakaman umum apabila penyediaan tempat pemakaman umum dilakukan dengan cata menyerahkan kompensasi berupa uang kepada pemerintah daerah',
                    'urutan' => 11,
                    'id_ssw' => 359,
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 12,
                    'nama' => 'Fotokopi akta notaris pernyataan pelepasan hak atas tanah dan / atau bangunan prasarana, sarana dan utilitas oleh pemohon / pengembang kepada pemerintah daerah',
                    'urutan' => 12,
                    'id_ssw' => 359,
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true,
                ],
            ];
    
            foreach ($data as $key => $value) {
                $berkas = Berkas::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($berkas))
                {
                    $berkas = new Berkas();
                }
    
                $berkas->id = $value['id'];
                $berkas->nama = $value['nama'];
                $berkas->urutan = $value['urutan'];
                $berkas->id_ssw = $value['id_ssw'];
                $berkas->is_bast_admin = $value['is_bast_admin'];
                $berkas->is_bast_fisik = $value['is_bast_fisik'];
                $berkas->save();
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

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Permohonan;
use App\Models\PermohonanTimeline;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PermohonanHistoriPenyelesaian;
use App\Models\Berkas;
use App\Models\PermohonanPersyaratanFile;

class SSWBASTAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssw:bast_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk mengambil data BAST Admin dari SSW';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(filter_var(config('myconfig.scheduler.ssw_admin'), FILTER_VALIDATE_BOOLEAN) == true)
        {
            DB::beginTransaction();
            try
            {
                // $getLastIdSSW = Permohonan::where('is_bast_admin', true)->orderBy('id_ssw', 'desc')->first();

                // if(!empty($getLastIdSSW))
                // {
                //     $permohonanSSW = DB::table('permohonan_ssw')
                //     ->where('id', '>', $getLastIdSSW->id_ssw)
                //     ->where('status', 1)->get();
                // }
                // else
                // {
                //     $permohonanSSW = DB::table('permohonan_ssw')
                //     ->where('status', 1)->get();
                // }

                $permohonanSSW = DB::table('permohonan_ssw')
                ->where('status', 1)->where('is_penarikan_psu', false)->get();

                foreach($permohonanSSW as $key => $value)
                {
                    $getInduk = null;
                    $countPermohonan = 1;
                    if(!empty($value->id_induk)) 
                    {
                        $checkParent = DB::table('permohonan_ssw')->where('id', $value->id_induk)->first();

                        if(!empty($checkParent) && $checkParent->status == 3)
                        {
                            $getInduk = Permohonan::where('id_ssw', $value->id_induk)->first();

                            if(!empty($getInduk))
                            {
                                $countPermohonan += Permohonan::where('id_induk_awal', $getInduk->id_induk_awal)->count();
                            }
                            else
                            {
                                $getInduk = null;
                            }
                        }
                    }

                   $getKecamatan = Kecamatan::withoutGlobalScope('isActive')->where([
                        'id_ssw' => $value->id_kecamatan,
                        'id_ssw_provinsi' => $value->id_provinsi,
                        'id_ssw_kabupaten' => $value->id_kabupaten
                    ])->first();
            
                    $getKelurahan = Kelurahan::withoutGlobalScopes(['isActive', 'checkRelationIsActive'])->where([
                        'id_ssw' => $value->id_kelurahan,
                        'id_ssw_provinsi' => $value->id_provinsi,
                        'id_ssw_kabupaten' => $value->id_kabupaten,
                        'id_ssw_kecamatan' => $value->id_kecamatan
                    ])->first();

                    $permohonan = new Permohonan();
                    $permohonan->id_ssw = $value->id;
                    $permohonan->id_induk = (!empty($getInduk)) ? $getInduk->id : null;
                    $permohonan->permohonan_ke = (!empty($getInduk)) ? $countPermohonan : 1;
                    $permohonan->is_bast_admin = true;
                    $permohonan->tanggal_permohonan = $value->tanggal_permohonan;
                    $permohonan->nomor_permohonan = $value->nomor_permohonan;
                    $permohonan->nama_subjek = $value->nama_subjek;
                    $permohonan->nama_perumahan = $value->nama_perumahan;
                    $permohonan->lampiran = $value->lampiran;
                    $permohonan->perihal = $value->perihal;
                    $permohonan->id_kecamatan = (!empty($getKecamatan)) ? $getKecamatan->id : null;
                    $permohonan->id_kelurahan = (!empty($getKelurahan)) ? $getKelurahan->id : null;
                    $permohonan->nomor_skrk = $value->nomor_skrk;
                    $permohonan->tanggal_skrk = $value->tanggal_skrk;
                    $permohonan->nomor_lampiran_gambar = $value->nomor_lampiran_gambar;
                    $permohonan->atas_nama = $value->atas_nama;
                    $permohonan->alamat = $value->alamat;
                    $permohonan->alamat_perumahan = $value->alamat_perumahan;
                    $permohonan->nama_perusahaan = $value->nama_perusahaan;
                    $permohonan->nama_pemohon = $value->nama_pemohon;
                    $permohonan->jabatan_pada_perusahaan = $value->jabatan_pada_perusahaan;
                    $permohonan->luas_lahan_pengembangan = $value->luas_lahan_pengembangan;
                    $permohonan->luas_prasarana_jalan_saluran = $value->luas_prasarana_jalan_saluran;
                    $permohonan->luas_sarana_fasilitas_umum = $value->luas_sarana_fasilitas_umum;
                    $permohonan->luas_sarana_rth = $value->luas_sarana_rth;
                    $permohonan->jenis_kegiatan = $value->jenis_kegiatan;
                    $permohonan->save();

                    $permohonanPersyarataFileSSW = DB::table('permohonan_ssw_persyaratan_file')
                    ->where('id_permohonan', $value->id)->get();

                    foreach($permohonanPersyarataFileSSW as $key2 => $value2)
                    {
                        $getBerkas = Berkas::withoutGlobalScope('isActive')->where('id_ssw', $value2->id_berkas)->where('is_bast_admin', true)->first();

                        $permohonanPersyarataFile = new PermohonanPersyaratanFile();
                        $permohonanPersyarataFile->id_ssw = $value2->id;
                        $permohonanPersyarataFile->id_permohonan = $permohonan->id;
                        $permohonanPersyarataFile->id_berkas = (!empty($getBerkas)) ? $getBerkas->id : null;
                        $permohonanPersyarataFile->nama = $value2->nama;
                        $permohonanPersyarataFile->path = $value2->path;
                        $permohonanPersyarataFile->ext = $value2->ext;
                        $permohonanPersyarataFile->ukuran = $value2->ukuran;
                        $permohonanPersyarataFile->is_gambar = $value2->is_gambar;
                        $permohonanPersyarataFile->save();
                    }

                    $permohonanHist = new PermohonanHistoriPenyelesaian();
                    $permohonanHist->id_permohonan = $permohonan->id;
                    $permohonanHist->id_proses_permohonan = 1;
                    $permohonanHist->jumlah_hari = 1;
                    $permohonanHist->jenis_bast = 1;
                    $permohonanHist->save();

                    $permohonanHist = new PermohonanHistoriPenyelesaian();
                    $permohonanHist->id_permohonan = $permohonan->id;
                    $permohonanHist->id_proses_permohonan = 2;
                    $permohonanHist->jenis_bast = 1;
                    $permohonanHist->save();

                    $permohonan = Permohonan::find($permohonan->id);
                    $permohonan->id_induk_awal = (!empty($getInduk)) ? $getInduk->id_induk_awal : $permohonan->id;
                    $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                    $permohonan->save();

                    DB::table('permohonan_ssw')
                    ->where('id', $value->id)->update(['is_penarikan_psu' => true]);

                    PermohonanTimeline::storeTimeline($permohonan->id, 1, 1);
                }

                DB::commit();
                $this->info('Data BAST Admin Berhasil Di Ambil Dari SSW');
            }
            catch (\Exception $ex)
            {
                DB::rollBack();
                $this->error($ex->getMessage());
            }
        }
        else
        {
            $this->info('Scheduler SSWBASTAdmin tidak aktif');
        }
    }
}

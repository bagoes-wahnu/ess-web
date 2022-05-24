<?php

namespace App\Http\Controllers\Api\Integrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use File;
use Storage;
use App\Models\Permohonan;
use App\Models\PermohonanTimeline;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PermohonanHistoriPenyelesaian;
use App\Models\Berkas;
use App\Models\PermohonanPersyaratanFile;

class KominfoIntegratorController extends Controller
{
    public function statusBast(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'no_registrasi' => 'required|unique:permohonan,nomor_permohonan',
                'tgl_registrasi' => 'required',
                'id_m_ijin' => 'required'
            ];

            $messages = [];

            $attributes = [
                'no_registrasi' => 'Nomor registrasi',
                'tgl_registrasi' => 'Tanggal registrasi',
                'id_m_ijin' => 'Id Master Ijin'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if ($validator->fails()) 
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => config('myconfig.integrator.kominfo.url') . '/api/perijinan_status',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "username": "' . config('myconfig.integrator.kominfo.username') . '",
                        "password": "' . config('myconfig.integrator.kominfo.password') . '",
                        "no_registrasi": "' . $request->no_registrasi . '",
                        "tgl_registrasi": "' . $request->tgl_registrasi . '",
                        "id_m_ijin": "' . $request->id_m_ijin . '"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    )
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);

                if ($response->status == true)
                {
                    if($request->id_m_ijin == 767)
                    {
                        $this->bastAdmin($response->result);
                    }
                    elseif($request->id_m_ijin == 768)
                    {
                        $this->bastFisik($response->result);
                    }
                    else
                    {
                        $this->responseCode = 400;
                        $this->responseMessage = 'Jenis ijin tidak diketahui';
                        DB::rollBack();
                        return response()->json($this->getResponse(), $this->responseCode);
                    }
                    
                    $this->responseCode = 200;
                    $this->responseMessage = 'Data BAST berhasil disimpan';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = $response->pesan;
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    private function bastAdmin($response)
    {
        $getKecamatan = Kecamatan::withoutGlobalScope('isActive')->where([
            'id_ssw' => $response->detail_transaksi->id_kec,
            'id_ssw_provinsi' => $response->detail_transaksi->id_prop,
            'id_ssw_kabupaten' => $response->detail_transaksi->id_kab
        ])->first();

        $getKelurahan = Kelurahan::withoutGlobalScopes(['isActive', 'checkRelationIsActive'])->where([
            'id_ssw' => $response->detail_transaksi->id_kel,
            'id_ssw_provinsi' => $response->detail_transaksi->id_prop,
            'id_ssw_kabupaten' => $response->detail_transaksi->id_kab,
            'id_ssw_kecamatan' => $response->detail_transaksi->id_kec
        ])->first();
        
        $permohonan = new Permohonan();
        $permohonan->id_ssw = null; //belum tahu
        $permohonan->id_induk = null; //belum tahu
        $permohonan->permohonan_ke = 1; //belum tahu
        $permohonan->is_bast_admin = true;
        $permohonan->tanggal_permohonan = date('Y-m-d', strtotime($response->pemohon->tgl_registrasi));
        $permohonan->nomor_permohonan = $response->pemohon->no_registrasi;
        $permohonan->nama_subjek = $response->detail_transaksi->nama_subyek;
        $permohonan->nama_perumahan = $response->detail_transaksi->perumahan;
        $permohonan->lampiran = null; //belum tahu
        $permohonan->perihal = null; //belum tahu
        $permohonan->id_kecamatan = (!empty($getKecamatan)) ? $getKecamatan->id : null;
        $permohonan->id_kelurahan = (!empty($getKelurahan)) ? $getKelurahan->id : null;
        $permohonan->nomor_skrk = $response->detail_transaksi->no_skrk;
        $permohonan->tanggal_skrk = date('Y-m-d', strtotime($response->detail_transaksi->tgl_skrk));
        $permohonan->nomor_lampiran_gambar = $response->detail_transaksi->gbr_skrk;
        $permohonan->atas_nama = $response->detail_transaksi->an_skrk;
        $permohonan->alamat = null; //belum tahu
        $permohonan->alamat_perumahan = $response->detail_transaksi->persil_skrk;
        $permohonan->nama_perusahaan = $response->detail_transaksi->nama_pt;
        $permohonan->nama_pemohon = $response->pemohon->nm_pemohon;
        $permohonan->jabatan_pada_perusahaan = $response->pemohon->pekerjaan_pemohon;
        $permohonan->luas_lahan_pengembangan = $response->detail_transaksi->luas;
        $permohonan->luas_prasarana_jalan_saluran = $response->detail_transaksi->pjsl;
        $permohonan->luas_sarana_fasilitas_umum = $response->detail_transaksi->sfu;
        $permohonan->luas_sarana_rth = $response->detail_transaksi->srth;
        $permohonan->jenis_kegiatan = null; //belum tahu
        $permohonan->save();

        foreach($response->detail_syarat as $key => $value)
        {
            if(!empty($value->file_upload))
            {
                $getBerkas = Berkas::withoutGlobalScope('isActive')->where('id_ssw', $value->id_m_syarat)->where('is_bast_admin', true)->first();

                if(!empty($getBerkas))
                {
                    $contents = @file_get_contents($value->file_upload);

                    if($contents == true)
                    {
                        $changedName = time() . random_int(100, 999) . basename($value->file_upload);
                        $path = 'bast_admin/' . $permohonan->id . '/berkas_persyaratan/' . $getBerkas->id;
                        Storage::put($path . '/' . $changedName, $contents);
                        $files = File::files(storage_path('app/' . $path));

                        $is_image = false;
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);
                        $mimeType = $finfo->file(storage_path('app/' . $path . '/' . $changedName));
                        
                        if(substr($mimeType, 0, 5) == 'image') {
                            $is_image = true;
                        }

                        $permohonanPersyarataFile = new PermohonanPersyaratanFile();
                        $permohonanPersyarataFile->id_ssw = null; //belum tahu
                        $permohonanPersyarataFile->id_permohonan = $permohonan->id;
                        $permohonanPersyarataFile->id_berkas = (!empty($getBerkas)) ? $getBerkas->id : null;
                        $permohonanPersyarataFile->nama = $files[0]->getFilename();
                        $permohonanPersyarataFile->path = $path . '/' . $changedName;
                        $permohonanPersyarataFile->ext = $files[0]->getExtension();
                        $permohonanPersyarataFile->ukuran = $files[0]->getSize();
                        $permohonanPersyarataFile->is_gambar = $is_image;
                        $permohonanPersyarataFile->save();
                    }
                }
            }
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
        $permohonan->id_induk_awal = $permohonan->id; //belum tahu
        $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
        $permohonan->save();

        PermohonanTimeline::storeTimeline($permohonan->id, 1, 1);
    }

    private function bastFisik($response)
    {
        $getKecamatan = Kecamatan::withoutGlobalScope('isActive')->where([
            'id_ssw' => $response->detail_transaksi->id_kec,
            'id_ssw_provinsi' => $response->detail_transaksi->id_prop,
            'id_ssw_kabupaten' => $response->detail_transaksi->id_kab
        ])->first();
        
        $getKelurahan = Kelurahan::withoutGlobalScopes(['isActive', 'checkRelationIsActive'])->where([
            'id_ssw' => $response->detail_transaksi->id_kel,
            'id_ssw_provinsi' => $response->detail_transaksi->id_prop,
            'id_ssw_kabupaten' => $response->detail_transaksi->id_kab,
            'id_ssw_kecamatan' => $response->detail_transaksi->id_kec
        ])->first();

        $permohonan = new Permohonan();
        $permohonan->id_ssw = null; //belum tahu
        $permohonan->id_induk_fisik = null; //belum tahu
        $permohonan->permohonan_fisik_ke = 1; //belum tahu
        $permohonan->is_bast_fisik = true;
        $permohonan->tanggal_permohonan = date('Y-m-d', strtotime($response->pemohon->tgl_registrasi));
        $permohonan->nomor_permohonan = $response->pemohon->no_registrasi;
        $permohonan->nama_subjek = $response->detail_transaksi->nama_subyek;
        $permohonan->nama_perumahan = $response->detail_transaksi->perumahan;
        $permohonan->lampiran = null; //belum tahu
        $permohonan->perihal = null; //belum tahu
        $permohonan->id_kecamatan = (!empty($getKecamatan)) ? $getKecamatan->id : null;
        $permohonan->id_kelurahan = (!empty($getKelurahan)) ? $getKelurahan->id : null;
        $permohonan->nomor_skrk = $response->detail_transaksi->no_skrk;
        $permohonan->tanggal_skrk = date('Y-m-d', strtotime($response->detail_transaksi->tgl_skrk));
        $permohonan->nomor_lampiran_gambar = $response->detail_transaksi->gbr_skrk;
        $permohonan->atas_nama = $response->detail_transaksi->an_skrk;
        $permohonan->alamat = null; //belum tahu
        $permohonan->alamat_perumahan = $response->detail_transaksi->persil_skrk;
        $permohonan->nama_perusahaan = $response->detail_transaksi->nama_pt;
        $permohonan->nama_pemohon = $response->pemohon->nm_pemohon;
        $permohonan->jabatan_pada_perusahaan = $response->pemohon->pekerjaan_pemohon;
        $permohonan->luas_lahan_pengembangan = $response->detail_transaksi->luas;
        $permohonan->luas_prasarana_jalan_saluran = $response->detail_transaksi->pjsl;
        $permohonan->luas_sarana_fasilitas_umum = $response->detail_transaksi->sfu;
        $permohonan->luas_sarana_rth = $response->detail_transaksi->srth;
        $permohonan->jenis_kegiatan = null; //belum tahu
        $permohonan->save();

        foreach($response->detail_syarat as $key => $value)
        {
            if(!empty($value->file_upload))
            {
                $getBerkas = Berkas::withoutGlobalScope('isActive')->where('id_ssw', $value->id_m_syarat)->where('is_bast_fisik', true)->first();

                if(!empty($getBerkas))
                {
                    $contents = @file_get_contents($value->file_upload);

                    if($contents == true)
                    {
                        $changedName = time() . random_int(100, 999) . basename($value->file_upload);
                        $path = 'bast_fisik/' . $permohonan->id . '/berkas_persyaratan/' . $getBerkas->id;
                        Storage::put($path . '/' . $changedName, $contents);
                        $files = File::files(storage_path('app/' . $path));

                        $is_image = false;
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);
                        $mimeType = $finfo->file(storage_path('app/' . $path . '/' . $changedName));
                        
                        if(substr($mimeType, 0, 5) == 'image') {
                            $is_image = true;
                        }

                        $permohonanPersyarataFile = new PermohonanPersyaratanFile();
                        $permohonanPersyarataFile->id_ssw = null; //belum tahu
                        $permohonanPersyarataFile->id_permohonan = $permohonan->id;
                        $permohonanPersyarataFile->id_berkas = (!empty($getBerkas)) ? $getBerkas->id : null;
                        $permohonanPersyarataFile->nama = $files[0]->getFilename();
                        $permohonanPersyarataFile->path = $path . '/' . $changedName;
                        $permohonanPersyarataFile->ext = $files[0]->getExtension();
                        $permohonanPersyarataFile->ukuran = $files[0]->getSize();
                        $permohonanPersyarataFile->is_gambar = $is_image;
                        $permohonanPersyarataFile->save();
                    }
                }
            }
        }

        $permohonanHist = new PermohonanHistoriPenyelesaian();
        $permohonanHist->id_permohonan = $permohonan->id;
        $permohonanHist->id_proses_permohonan = 8;
        $permohonanHist->jumlah_hari = 1;
        $permohonanHist->jenis_bast = 2;
        $permohonanHist->save();

        $permohonanHist = new PermohonanHistoriPenyelesaian();
        $permohonanHist->id_permohonan = $permohonan->id;
        $permohonanHist->id_proses_permohonan = 9;
        $permohonanHist->jenis_bast = 2;
        $permohonanHist->save();

        $permohonan = Permohonan::find($permohonan->id);
        $permohonan->id_induk_fisik_awal = $permohonan->id; //belum tahu
        $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
        $permohonan->save();

        PermohonanTimeline::storeTimeline($permohonan->id, 1, 2);
    }
}

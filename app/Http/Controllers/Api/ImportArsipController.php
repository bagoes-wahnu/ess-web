<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\HariLibur;
use App\Models\Berkas;
use App\Models\Dinas;
use DB;

class ImportArsipController extends Controller
{
    public function dinas(Request $request)
    {
        
        $data = $this->getSyncMaster('dinas');
        foreach ($data as $key => $val) {
            
            $value = (array)$val;
            $find = Dinas::withoutGlobalScope('isActive')->where('id_arsip',$value['id'])->first();
            $dinas = []; 
            if($find !== NULL)
            {
                $find->update(['nama'=>$value['nama']]);
            }
            else
            {
                $data = Dinas::insert(['id_arsip'=>$value['id'],'nama'=>$value['nama']]);
            }

        }

        $response = [
            'message' => 'Sinkronisasi Berhasil'
        ];

        return response()->json($response, 200);
    }

    public function berkas(Request $request)
    {
        
        $data = $this->getSyncMaster('berkas');
        foreach ($data as $key => $val) {
            
            $value = (array)$val;
            $find = Berkas::withoutGlobalScope('isActive')->where('id_arsip',$value['id'])->first();
            if($find !== NULL)
            {
                $find->update(['nama'=>$value['nama'],'urutan'=>$value['urutan']]);
            }
            else
            {
                $data = Berkas::insert(['id_arsip'=>$value['id'],'nama'=>$value['nama'],'urutan'=>$value['urutan']]);
            }

        }

        $response = [
            'message' => 'Sinkronisasi Berhasil'
        ];

        return response()->json($response, 200);
    }

    

    public function hari_libur(Request $request)
    {
        
        $data = $this->getSyncMaster('hari_libur');
        foreach ($data as $key => $val) {
            
            $value = (array)$val;
            $find = HariLibur::withoutGlobalScope('isActive')->where('id_arsip',$value['id'])->first();
            if($find !== NULL)
            {
                $find->update(['nama'=>$value['nama'], 'tanggal_awal'=>$value['tanggal_awal'], 'tanggal_akhir'=>$value['tanggal_akhir']]);
            }
            else
            {
                $data = HariLibur::insert(['id_arsip'=>$value['id'], 'nama'=>$value['nama'], 'tanggal_awal'=>$value['tanggal_awal'], 'tanggal_akhir'=>$value['tanggal_akhir']]);
            }

        }

        $response = [
            'message' => 'Sinkronisasi Berhasil'
        ];

        return response()->json($response, 200);
    }

    public function kecamatan(Request $request)
    {
        
        $data = $this->getSyncMaster('kecamatan');
        
        foreach ($data as $key => $val) {
            
            $value = (array)$val;
            $find = Kecamatan::withoutGlobalScope('isActive')->where('id_arsip',$value['id'])->first();
            
            if($find !== NULL)
            {
                $find->update(['nama'=>$value['nama']]);
            }
            else
            {
                $data = Kecamatan::insert(['id_arsip'=>$value['id'],'nama'=>$value['nama']]);
            }

        }

        $response = [
            'message' => 'Sinkronisasi Berhasil'
        ];

        return response()->json($response, 200);
    }

    public function kelurahan(Request $request)
    {
        
        $data = $this->getSyncMaster('kelurahan');
        
        foreach ($data as $key => $val) {
            
            $value = (array)$val;
            $find = Kelurahan::withoutGlobalScope('isActive')->where('id_arsip',$value['id'])->first();
            $findKecamatan = Kecamatan::withoutGlobalScope('isActive')->where('id_arsip',$value['id_kecamatan'])->first();
            
            if($find !== NULL && $findKecamatan !== NULL)
            {
                $find->update(['nama'=>$value['nama']]);
            }
            
            if($find == NULL && $findKecamatan !== NULL)
            {
                $data = Kelurahan::insert(['id_arsip'=>$value['id'],'nama'=>$value['nama'],'id_kecamatan'=>$findKecamatan->id]);
            }

        }

        $response = [
            'message' => 'Sinkronisasi Berhasil'
        ];

        return response()->json($response, 200);
    }
}

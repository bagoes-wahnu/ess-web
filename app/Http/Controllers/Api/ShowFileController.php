<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use App\Models\PermohonanPersyaratanFile;
use App\Models\PermohonanVerifikasiFile;
use App\Models\PermohonanBeritaAcaraFile;
use App\Models\PermohonanKonsepFile;
use App\Models\PermohonanKoreksiKonsepDetailFile;
use App\Models\PermohonanPersetujuanTeknisFile;
use App\Models\PermohonanSurveyFile;
use App\Models\PermohonanEvaluasiSurveyFile;
use App\Models\Ttd;

class ShowFileController extends Controller
{
    public function index(Request $request)
    {
        $file = null;
        if($request->transaction == 'permohonan_persyaratan')
        {
            $file = PermohonanPersyaratanFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_verifikasi')
        {
            $file = PermohonanVerifikasiFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_berita_acara')
        {
            $file = PermohonanBeritaAcaraFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_konsep')
        {
            $file = PermohonanKonsepFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_koreksi_konsep_detail')
        {
            $file = PermohonanKoreksiKonsepDetailFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_persetujuan_teknis')
        {
            $file = PermohonanPersetujuanTeknisFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_survey')
        {
            $file = PermohonanSurveyFile::find($request->id);
        }
        elseif($request->transaction == 'permohonan_evaluasi_survey')
        {
            $file = PermohonanEvaluasiSurveyFile::find($request->id);
        }
        elseif($request->transaction == 'ttd_kadis')
        {
            $preFile = Ttd::find($request->id);
            $file = new \stdClass;
            $file->path = $preFile->path;
            $file->is_gambar = $preFile->is_gambar;
            $file->ext = $preFile->ext;
            $file->nama = $preFile->nama;
        }
        elseif($request->transaction == 'stempel')
        {
            $preFile = Ttd::find($request->id);
            $file = new \stdClass;
            $file->path = $preFile->path_stempel;
            $file->is_gambar = $preFile->stempel_is_gambar;
            $file->ext = $preFile->ext_stempel;
            $file->nama = $preFile->nama_stempel;
        }
        else
        {
            $this->responseCode = 400;
            $this->responseMessage = 'Jenis transaksi tidak diketahui';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if($file)
        {
            $path = storage_path('app/' . $file->path);

            if(File::exists($path))
            {
                $this->responseCode = 200;
                $this->responseMessage = 'File ditemukan';

                if($file->is_gambar == true || $file->ext == 'pdf')
                {
                    if($request->filled('preview'))
                    {
                        if(filter_var($request->preview, FILTER_VALIDATE_BOOLEAN) == true)
                        {
                            return response()->file($path);
                        }
                        else
                        {
                            return response()->download($path, $file->nama);
                        }
                    }
                    else
                    {
                        return response()->download($path, $file->nama);
                    }
                }
                else
                {
                    return response()->download($path, $file->nama);
                }
            }
            else
            {
                $this->responseCode = 404;
                $this->responseMessage = 'File tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
        }
        else
        {
            $this->responseCode = 400;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use File;
use App\Models\Ttd;
use App\Http\Resources\TtdResource;

class TtdController extends Controller
{
    public function index()
    {
        try
        {
            $ttd = Ttd::first();

            $this->responseCode = 200;
            $this->responseMessage = 'Data ttd berhasil ditampilkan';
            $this->responseData['ttd'] = (!empty($ttd)) ? new TtdResource($ttd) : null;
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function storeOrUpdate(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'nip' => 'required',
                'nama_kadis' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nip' => 'NIP',
                'nama_kadis' => 'Nama kepala dinas'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $ttd = Ttd::first();

                if(empty($ttd))
                {
                    $ttd = new Ttd();
                }

                $ttd->nip = $request->nip;
                $ttd->nama_kadis = $request->nama_kadis;
                $ttd->save();

                $this->responseCode = 200;
                $this->responseMessage = 'File berhasil diupload';
                $this->responseData['ttd'] = new TtdResource($ttd);
                DB::commit();
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

    public function uploadTtdFile(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'nullable|file|mimes:png'
            ];

            $messages = [];

            $attributes = [
                'file' => 'Unggahan TTD'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $ttd = Ttd::first();

                if(!empty($ttd))
                {
                    if($request->hasFile('file'))
                    {
                        if(!empty($ttd->path)) {
                            if(File::exists(storage_path('app/' . $ttd->path))) {
                                File::delete(storage_path('app/' . $ttd->path));
                            }
                        }

                        $file = $request->file;

                        $changedName = time() . random_int(100, 999) . $file->getClientOriginalName();
                        
                        $is_image = false;
                        if(substr($file->getClientMimeType(), 0, 5) == 'image') {
                            $is_image = true;
                        }
                        
                        $path = 'ttd_kadis/' . $ttd->id;
                        $file->storeAs($path, $changedName);

                        $ttd->nama = $file->getClientOriginalName();
                        $ttd->path = $path . '/' . $changedName;
                        $ttd->ukuran = $file->getSize();
                        $ttd->ext = $file->getClientOriginalExtension();
                        $ttd->is_gambar = $is_image;
                        $ttd->save();
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data ttd tidak ditemukan';
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

    public function uploadStempelFile(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'nullable|file|mimes:png'
            ];

            $messages = [];

            $attributes = [
                'file' => 'Unggahan Stempel'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $ttd = Ttd::first();

                if(!empty($ttd))
                {
                    if($request->hasFile('file'))
                    {
                        if(!empty($ttd->path_stempel)) {
                            if(File::exists(storage_path('app/' . $ttd->path_stempel))) {
                                File::delete(storage_path('app/' . $ttd->path_stempel));
                            }
                        }

                        $file = $request->file;

                        $changedNameStempel = time() . random_int(100, 999) . $file->getClientOriginalName();
                        
                        $stempel_is_image = false;
                        if(substr($file->getClientMimeType(), 0, 5) == 'image') {
                            $stempel_is_image = true;
                        }
                        
                        $path_stempel = 'stempel/' . $ttd->id;
                        $file->storeAs($path_stempel, $changedNameStempel);

                        $ttd->nama_stempel = $file->getClientOriginalName();
                        $ttd->path_stempel = $path_stempel . '/' . $changedNameStempel;
                        $ttd->ukuran_stempel = $file->getSize();
                        $ttd->ext_stempel = $file->getClientOriginalExtension();
                        $ttd->stempel_is_gambar = $stempel_is_image;
                        $ttd->save();
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data ttd tidak ditemukan';
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
}

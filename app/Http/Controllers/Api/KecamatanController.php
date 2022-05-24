<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Kecamatan;
use App\Models\User;
use App\Http\Resources\KecamatanResource;

class KecamatanController extends Controller
{
    public function storeByArsip(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'id_arsip' => 'nullable|unique:App\Models\Kecamatan,id_arsip'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kecamatan',
                'id_arsip' => 'ID Arsip',
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
                $kecamatan = new Kecamatan();
                $kecamatan->nama = $request->nama;
                $kecamatan->id_arsip = $request->id_arsip;
                $kecamatan->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data kecamatan berhasil disimpan';
                $this->responseData['kecamatan'] = new KecamatanResource($kecamatan->refresh());
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

    public function updateByArsip(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'nama' => 'required',
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kecamatan',
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
                $kecamatan = Kecamatan::withoutGlobalScope('isActive')->where('id_arsip',$id)->first();

                if(!empty($kecamatan))
                {
                    $kecamatan->nama = $request->nama;
                    $kecamatan->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data kecamatan berhasil diedit';
                    $this->responseData['kecamatan'] = new KecamatanResource($kecamatan->refresh());
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data berkas tidak ditemukan';
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

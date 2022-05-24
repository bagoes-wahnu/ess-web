<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\User;
use App\Http\Resources\KelurahanResource;

class KelurahanController extends Controller
{
    public function storeByArsip(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'id_arsip_kecamatan' => 'required|exists:App\Models\Kecamatan,id_arsip',
                'id_arsip' => 'nullable|unique:App\Models\Kelurahan,id_arsip'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kelurahan',
                'id_arsip_kecamatan' => 'ID Arsip Kecamatan',
                'id_arsip' => 'ID Arsip'
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
                $kecamatan = Kecamatan::withoutGlobalScope('isActive')->where('id_arsip',$request->id_arsip_kecamatan)->first();
                
                $kelurahan = new Kelurahan();
                $kelurahan->nama = $request->nama;
                $kelurahan->id_kecamatan = $kecamatan->id;
                $kelurahan->id_arsip = $request->id_arsip;
                $kelurahan->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data kecamatan berhasil disimpan';
                $this->responseData['kecamatan'] = new KelurahanResource($kelurahan->refresh());
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
                'id_arsip_kecamatan' => 'required|exists:App\Models\Kecamatan,id_arsip'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kelurahan',
                'id_arsip_kecamatan' => 'ID Arsip Kecamatan'
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
                $kelurahan = Kelurahan::withoutGlobalScope('isActive')->where('id_arsip',$id)->first();
                $kecamatan = Kecamatan::withoutGlobalScope('isActive')->where('id_arsip',$request->id_arsip_kecamatan)->first();

                if(!empty($kelurahan))
                {
                    $kelurahan->nama = $request->nama;
                    $kelurahan->id_kecamatan = $kecamatan->id;
                    $kelurahan->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data kecamatan berhasil diedit';
                    $this->responseData['kecamatan'] = new KelurahanResource($kelurahan->refresh());
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data kecamatan tidak ditemukan';
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

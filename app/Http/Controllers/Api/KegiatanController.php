<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Kegiatan;
use App\Http\Resources\KegiatanResource;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        return Kegiatan::get_data('datatables');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kegiatan',
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
                $kegiatan = new Kegiatan();
                $kegiatan->nama = $request->nama;
                $kegiatan->id_ssw = $request->id_ssw;
                $kegiatan->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data kegiatan berhasil disimpan';
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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'nama' => 'required',
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama kegiatan',
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
                $kegiatan = Kegiatan::find($id);

                if(!empty($kegiatan))
                {
                    $kegiatan->nama = $request->nama;
                    $kegiatan->id_ssw = $request->id_ssw;
                    $kegiatan->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data kegiatan berhasil diedit';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data kegiatan tidak ditemukan';
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

	public function show($id)
    {
        try
        {
            $kegiatan = Kegiatan::find($id);

            if(!empty($kegiatan)) 
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data kegiatan berhasil ditampilkan';
                $this->responseData['kegiatan'] = new KegiatanResource($kegiatan);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data kegiatan tidak ditemukan';
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function changeStatus($id)
    {
        DB::beginTransaction();
        try
        {
            $kegiatan = Kegiatan::find($id);

            if(!empty($kegiatan)) 
            {
                $kegiatan->status = ($kegiatan->status == true) ? false : true;
                $kegiatan->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Status kegiatan berhasil diubah';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data kegiatan tidak ditemukan';
                DB::rollBack();
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $kegiatan = Kegiatan::find($id);

            if(!empty($kegiatan)) 
            {
                $kegiatan->delete();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Data kegiatan berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data kegiatan tidak ditemukan';
                DB::rollBack();
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

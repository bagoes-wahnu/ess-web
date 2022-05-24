<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Berkas;
use App\Http\Resources\BerkasResource;

class BerkasController extends Controller
{
    public function index(Request $request)
    {
        return Berkas::get_data('datatables');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'urutan' => 'required|unique:m_berkas,urutan',
                'is_bast_admin' => 'required',
                'is_bast_fisik' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama berkas',
                'urutan' => 'Urutan',
                'is_bast_admin' => 'BAST Admin',
                'is_bast_fisik' => 'BAST Fisik'
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
                // $id_arsip = $this->syncMaster(['nama'=>$request->nama,'urutan'=>$request->urutan],'berkas/store');
                
                // if(!empty($id_arsip))
                // {
                //     $berkas = new Berkas();
                //     $berkas->nama = $request->nama;
                //     $berkas->urutan = $request->urutan;
                //     $berkas->id_ssw = $request->id_ssw;
                //     $berkas->id_arsip = $id_arsip;
                //     $berkas->is_bast_admin = $request->is_bast_admin;
                //     $berkas->is_bast_fisik = $request->is_bast_fisik;
                //     $berkas->save();
    
                //     $this->responseCode = 200;
                //     $this->responseMessage = 'Data berkas berhasil disimpan';
                //     DB::commit();
                // }
                // else
                // {
                //     $this->responseCode = 400;
                //     $this->responseMessage = 'Sinkron data gagal';
                //     DB::rollBack();
                // }

                $berkas = new Berkas();
                $berkas->nama = $request->nama;
                $berkas->urutan = $request->urutan;
                $berkas->id_ssw = $request->id_ssw;
                $berkas->is_bast_admin = $request->is_bast_admin;
                $berkas->is_bast_fisik = $request->is_bast_fisik;
                $berkas->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data berkas berhasil disimpan';
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
                'urutan' => "required|unique:m_berkas,urutan,{$id}",
                'is_bast_admin' => 'required',
                'is_bast_fisik' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama berkas',
                'urutan' => 'Urutan',
                'is_bast_admin' => 'BAST Admin',
                'is_bast_fisik' => 'BAST Fisik'
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
                $berkas = Berkas::withoutGlobalScope('isActive')->find($id);

                if(!empty($berkas))
                {
                    // if($berkas->id_arsip !== NULL)
                    // $id_arsip = $this->syncMaster(['nama'=>$request->nama,'urutan'=>$request->urutan],'berkas/store',$berkas->id_arsip);
                    
                    $berkas->nama = $request->nama;
                    $berkas->urutan = $request->urutan;
                    // $berkas->id_arsip = $id_arsip;
                    $berkas->id_ssw = $request->id_ssw;
                    $berkas->is_bast_admin = $request->is_bast_admin;
                    $berkas->is_bast_fisik = $request->is_bast_fisik;
                    $berkas->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data berkas berhasil diedit';
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


    public function storeByArsip(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'urutan' => 'required|unique:m_berkas,urutan'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama berkas',
                'urutan' => 'Urutan'
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
                $berkas = new Berkas();
                $berkas->nama = $request->nama;
                $berkas->urutan = $request->urutan;
                $berkas->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data berkas berhasil disimpan';
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
                'urutan' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama berkas',
                'urutan' => 'Urutan'
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
                $berkas = Berkas::withoutGlobalScope('isActive')->where('id_arsip',$id)->firstOrFail();

                if(!empty($berkas))
                {
                    $berkas->nama = $request->nama;
                    $berkas->urutan = $request->urutan;
                    $berkas->id_arsip = $id;
                    $berkas->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data berkas berhasil diedit';
                    $this->responseData['berkas'] = new BerkasResource($berkas->refresh());
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

    public function show($id)
    {
        try
        {
            $berkas = Berkas::withoutGlobalScope('isActive')->find($id);

            if(!empty($berkas)) 
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data berkas berhasil ditampilkan';
                $this->responseData['berkas'] = new BerkasResource($berkas);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data berkas tidak ditemukan';
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
            $berkas = Berkas::withoutGlobalScope('isActive')->find($id);

            if(!empty($berkas)) 
            {
                $berkas->status = ($berkas->status == true) ? false : true;
                $berkas->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Status berkas berhasil diubah';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data berkas tidak ditemukan';
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
            $berkas = Berkas::withoutGlobalScope('isActive')->find($id);

            if(!empty($berkas)) 
            {
                $berkas->delete();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Data berkas berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data berkas tidak ditemukan';
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

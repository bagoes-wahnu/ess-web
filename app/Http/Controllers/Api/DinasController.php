<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Dinas;
use App\Http\Resources\DinasResource;

class DinasController extends Controller
{
    public function index(Request $request)
    {
        return Dinas::get_data('datatables');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'telepon' => 'required',
                'alamat' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama dinas',
                'telepon' => 'Telepon',
                'alamat' => 'Alamat'
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
                $id_arsip = $this->syncMaster(['nama'=>$request->nama],'dinas/store');
                
                $dinas = new Dinas();
                $dinas->nama = $request->nama;
                $dinas->telepon = $request->telepon;
                $dinas->alamat = $request->alamat;
                $dinas->id_arsip = $id_arsip;
                $dinas->id_ssw = $request->id_ssw;
                $dinas->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data dinas berhasil disimpan';
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
                'telepon' => 'required',
                'alamat' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama dinas',
                'telepon' => 'Telepon',
                'alamat' => 'Alamat'
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
                $dinas = Dinas::withoutGlobalScope('isActive')->find($id);

                if(!empty($dinas))
                {
                    $id_arsip = $this->syncMaster(['nama'=>$request->nama],'dinas/store',$id);

                    $dinas->nama = $request->nama;
                    $dinas->telepon = $request->telepon;
                    $dinas->alamat = $request->alamat;
                    $dinas->id_arsip = $id_arsip;
                    $dinas->id_ssw = $request->id_ssw;
                    $dinas->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data dinas berhasil diedit';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data dinas tidak ditemukan';
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
            $dinas = Dinas::withoutGlobalScope('isActive')->find($id);

            if(!empty($dinas)) 
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data dinas berhasil ditampilkan';
                $this->responseData['dinas'] = new DinasResource($dinas);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data dinas tidak ditemukan';
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
            $dinas = Dinas::withoutGlobalScope('isActive')->find($id);

            if(!empty($dinas)) 
            {
                $dinas->status = ($dinas->status == true) ? false : true;
                $dinas->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Status dinas berhasil diubah';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data dinas tidak ditemukan';
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
            $dinas = Dinas::withoutGlobalScope('isActive')->find($id);

            if(!empty($dinas)) 
            {
                $dinas->delete();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Data dinas berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data dinas tidak ditemukan';
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

    public function storeByArsip(Request $request)
    {
        DB::beginTransaction();
        try
        {
             $rules = [
                'nama' => 'required',
                // 'telepon' => 'required',
                // 'alamat' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama dinas',
                // 'telepon' => 'Telepon',
                // 'alamat' => 'Alamat'
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
                $dinas = new Dinas();
                $dinas->nama = $request->nama;
                $dinas->telepon = $request->telepon;
                $dinas->alamat = $request->alamat;
                $dinas->id_arsip = $request->id_arsip;
                // $dinas->id_ssw = $request->id_ssw;
                $dinas->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data dinas berhasil disimpan';
                $this->responseData['dinas'] = new DinasResource($dinas->refresh());
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
                // 'telepon' => 'required',
                // 'alamat' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama dinas',
                // 'telepon' => 'Telepon',
                // 'alamat' => 'Alamat'
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
                // dd("test");
                $dinas = Dinas::withoutGlobalScope('isActive')->where('id_arsip',$id)->firstOrFail();
                if(!empty($dinas)) 
                {
                    $dinas->nama = $request->nama;
                    $dinas->telepon = $request->telepon;
                    $dinas->alamat = $request->alamat;
                    $dinas->id_arsip = $id;
                    $dinas->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data dinas berhasil diedit';
                    $this->responseData['dinas'] = new DinasResource($dinas->refresh());
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data dinas tidak ditemukan';
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

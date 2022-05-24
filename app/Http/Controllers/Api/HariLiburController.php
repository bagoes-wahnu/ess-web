<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\HariLibur;
use App\Http\Resources\HariLiburResource;

class HariLiburController extends Controller
{
    public function index(Request $request)
    {
        return HariLibur::get_data('datatables');
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        try 
        {
            $rules = [
                'nama' => 'required',
                'tanggal_awal' => 'required|before_or_equal:tanggal_akhir',
                'tanggal_akhir' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama hari libur',
                'tanggal_awal' => 'Tanggal awal',
                'tanggal_akhir' => 'Tanggal akhir'
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
                $id_arsip = $this->syncMaster(['nama'=>$request->nama,'tanggal_awal'=>$request->tanggal_awal,'tanggal_akhir'=>$request->tanggal_akhir],'hari_libur/store');
                
                $hariLibur = new HariLibur();
                $hariLibur->nama = $request->nama;
                $hariLibur->tanggal_awal = $request->tanggal_awal;
                $hariLibur->tanggal_akhir = $request->tanggal_akhir;
                $hariLibur->id_arsip = $id_arsip;
                $hariLibur->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data hari libur berhasil disimpan';
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
                'tanggal_awal' => 'required|before_or_equal:tanggal_akhir',
                'tanggal_akhir' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama hari libur',
                'tanggal_awal' => 'Tanggal awal',
                'tanggal_akhir' => 'Tanggal akhir'
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
                $hariLibur = HariLibur::withoutGlobalScope('isActive')->find($id);

                if(!empty($hariLibur))
                {
                    $id_arsip = $this->syncMaster(['nama'=>$request->nama,'tanggal_awal'=>$request->tanggal_awal,'tanggal_akhir'=>$request->tanggal_akhir],'hari_libur/store',$id);
                    
                    $hariLibur->nama = $request->nama;
                    $hariLibur->tanggal_awal = $request->tanggal_awal;
                    $hariLibur->tanggal_akhir = $request->tanggal_akhir;
                    $hariLibur->id_arsip = $id_arsip;
                    $hariLibur->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data hari libur berhasil diedit';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data hari libur tidak ditemukan';
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
            $dinas = HariLibur::withoutGlobalScope('isActive')->find($id);

            if(!empty($dinas)) 
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data hari libur berhasil ditampilkan';
                $this->responseData['hari_libur'] = new HariLiburResource($dinas);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data hari libur tidak ditemukan';
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
            $hariLibur = HariLibur::withoutGlobalScope('isActive')->find($id);

            if(!empty($hariLibur)) 
            {
                $hariLibur->status = ($hariLibur->status == true) ? false : true;
                $hariLibur->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Status hari libur berhasil diubah';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data hari libur tidak ditemukan';
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
            $hariLibur = HariLibur::withoutGlobalScope('isActive')->find($id);

            if(!empty($hariLibur)) 
            {
                $hariLibur->delete();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Data hari libur berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data hari libur tidak ditemukan';
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
                'tanggal_awal' => 'required|before_or_equal:tanggal_akhir',
                'tanggal_akhir' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama hari libur',
                'tanggal_awal' => 'Tanggal awal',
                'tanggal_akhir' => 'Tanggal akhir'
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
                $hariLibur = new HariLibur();
                $hariLibur->nama = $request->nama;
                $hariLibur->tanggal_awal = $request->tanggal_awal;
                $hariLibur->tanggal_akhir = $request->tanggal_akhir;
                $hariLibur->id_arsip = $request->id_arsip;
                $hariLibur->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data hari libur berhasil disimpan';
                $this->responseData['hari_libur'] = new HariLiburResource($hariLibur->refresh());
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
                'tanggal_awal' => 'required|before_or_equal:tanggal_akhir',
                'tanggal_akhir' => 'required'
            ];

            $messages = [];

            $attributes = [
                'nama' => 'Nama hari libur',
                'tanggal_awal' => 'Tanggal awal',
                'tanggal_akhir' => 'Tanggal akhir'
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
                $hariLibur = HariLibur::withoutGlobalScope('isActive')->where('id_arsip',$id)->firstOrFail();
                if(!empty($hariLibur)) 
                {

                    $hariLibur->nama = $request->nama;
                    $hariLibur->tanggal_awal = $request->tanggal_awal;
                    $hariLibur->tanggal_akhir = $request->tanggal_akhir;
                    $hariLibur->id_arsip = $id;
                    $hariLibur->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data hari libur berhasil diedit';
                    $this->responseData['hari_libur'] = new HariLiburResource($hariLibur->refresh());
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data hari libur tidak ditemukan';
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

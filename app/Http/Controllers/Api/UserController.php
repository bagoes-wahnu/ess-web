<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use App\Models\User;
use App\Models\UserKecamatan;
use App\Models\UserKelurahan;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $params = new \stdClass;
        $params->id_role = $request->filled('id_role') ? $request->id_role : null;
        $params->id_dinas = $request->filled('id_dinas') ? $request->id_dinas : null;
        $params->id_kecamatan = $request->filled('id_kecamatan') ? $request->id_kecamatan : null;
        $params->id_kelurahan = $request->filled('id_kelurahan') ? $request->id_kelurahan : null;

        return User::get_data('datatables', $params);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'id_role' => 'required|exists:m_role,id',
                'id_dinas' => 'nullable|required_if:id_role,1|exists:m_dinas,id',
                'list_kecamatan' => 'nullable|required_if:id_role,6,7|array|min:1',
                'list_kecamatan.*' => 'required|exists:m_kecamatan,id',
                'list_kelurahan' => 'nullable|required_if:id_role,6|array|min:1',
                'list_kelurahan.*' => 'required|exists:m_kelurahan,id',
                'nama' => 'required',
                'username' => 'required|unique:m_user,username',
                'password' => 'required|confirmed',
                'email' => 'nullable|required_if:id_role,6|unique:m_user,email'

            ];

            $messages = [];

            $attributes = [
                'id_role' => 'Hak akses',
                'id_dinas' => 'Dinas',
                'list_kecamatan' => 'Kecamatan',
                'list_kecamatan.*' => 'Kecamatan',
                'list_kelurahan' => 'Kelurahan',
                'list_kelurahan.*' => 'Kelurahan',
                'nama' => 'Nama user',
                'username' => 'Username',
                'password' => 'Password',
                'email' => 'Email'
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
                $user = new User();
                $user->nama = $request->nama;
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->id_role = $request->id_role;
                $user->id_dinas = ($request->id_role != 1 ) ? $request->id_dinas : null;
                $user->email = ($request->id_role == 6) ? $request->email : null;
                $user->save();

                if(in_array($request->id_role, array(6, 7)))
                {
                    foreach ($request->list_kecamatan as $key => $value) {
                        $user->kecamatan()->attach($value);
                    }
                }

                if($request->id_role == 6)
                {
                    foreach ($request->list_kelurahan as $key => $value) {
                        $user->kelurahan()->attach($value);
                    }
                }

                $this->responseCode = 200;
                $this->responseMessage = 'Data user berhasil disimpan';
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
                'id_role' => 'required|exists:m_role,id',
                'id_dinas' => 'nullable|required_if:id_role,1|exists:m_dinas,id',
                'list_kecamatan' => 'nullable|required_if:id_role,6,7|array|min:1',
                'list_kecamatan.*' => 'required|exists:m_kecamatan,id',
                'list_kelurahan' => 'nullable|required_if:id_role,6|array|min:1',
                'list_kelurahan.*' => 'required|exists:m_kelurahan,id',
                'nama' => 'required',
                'username' => "required|unique:m_user,username,{$id}",
                'password' => 'nullable|confirmed',
                'email' => "nullable|required_if:id_role,6|unique:m_user,email,{$id}"
            ];

            $messages = [];

            $attributes = [
                'id_role' => 'Hak akses',
                'id_dinas' => 'Dinas',
                'list_kecamatan' => 'Kecamatan',
                'list_kecamatan.*' => 'Kecamatan',
                'list_kelurahan' => 'Kelurahan',
                'list_kelurahan.*' => 'Kelurahan',
                'nama' => 'Nama user',
                'username' => 'Username',
                'password' => 'Password',
                'email' => 'Email'
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
                $user = User::withoutGlobalScope('isActive')->find($id);

                if(!empty($user))
                {
                    $user->nama = $request->nama;
                    $user->username = $request->username;
                    $user->password = $request->filled('password') ? Hash::make($request->password) : $user->password;
                    $user->id_role = $request->id_role;
                    $user->id_dinas = ($request->id_role != 1 ) ? $request->id_dinas : null;
                    $user->email = ($request->id_role == 6) ? $request->email : null;
                    $user->save();
    
                    $user->kecamatan()->detach();
                    $user->kelurahan()->detach();

                    if(in_array($request->id_role, array(6, 7)))
                    {
                        foreach ($request->list_kecamatan as $key => $value) {
                            $user->kecamatan()->attach($value);
                        }
                    }

                    if($request->id_role == 6)
                    {
                        foreach ($request->list_kelurahan as $key => $value) {
                            $user->kelurahan()->attach($value);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data user berhasil diedit';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data user tidak ditemukan';
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

    public function passwordReset($id)
    {
        DB::beginTransaction();
        try
        {
            $user = User::withoutGlobalScope('isActive')->find($id);

            if(!empty($user))
            {
                $user->password = Hash::make(config('myconfig.default_password'));
                $user->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Password user berhasil direset';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data user tidak ditemukan';
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

    public function show($id)
    {
        try
        {
            $user = User::withoutGlobalScope('isActive')->with(['role', 'dinas', 'kecamatan', 'kelurahan'])->find($id);

            if(!empty($user))
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data user berhasil ditampilkan';
                $this->responseData['user'] = new UserResource($user);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data user tidak ditemukan';
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
            $user = User::withoutGlobalScope('isActive')->find($id);

            if(!empty($user))
            {
                $user->status = ($user->status == true) ? false : true;
                $user->save();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Status user berhasil diubah';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data user tidak ditemukan';
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
            $user = User::withoutGlobalScope('isActive')->find($id);

            if(!empty($user))
            {
                $user->delete();
                
                $this->responseCode = 200;
                $this->responseMessage = 'Data user berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data user tidak ditemukan';
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

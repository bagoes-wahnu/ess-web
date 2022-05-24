<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DB;
use Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                'username' => 'required',
                'password' => 'required'
            ];

            $messages = [];

            $attributes = [
                'username' => 'Username',
                'password' => 'Password'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
    
            if($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
            }
            else {
                $credentials = $request->only('username', 'password');
                $token = auth('api')->attempt($credentials);

                if (!empty($token)) {
                    if(auth('api')->user()->status == true) {
                        $userAuth = User::with(['role', 'dinas', 'kecamatan', 'kelurahan'])->find(auth('api')->user()->id);
                        
                        if(!empty($userAuth->role)) {
                            $this->responseCode = 200;
                            $this->responseMessage = 'User berhasil login';
                            $this->responseData['user'] = new UserResource($userAuth);
                            $this->responseData['token'] = $this->respondWithToken($token);
                        }
                        else {
                            auth('api')->invalidate();
                            $this->responseCode = 401;
                            $this->responseMessage = 'Hak akses anda tidak diketahui';
                        }
                    }
                    else {
                        auth('api')->invalidate();
                        $this->responseCode = 401;
                        $this->responseMessage = 'User anda telah dinonaktifkan';
                    }
                }
                else {
                    $this->responseCode = 401;
                    $this->responseMessage = 'User tidak ditemukan';
                }
            }
        } 
        catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function me()
    {
        try {
            $userAuth = User::with(['role', 'dinas', 'kecamatan', 'kelurahan'])->find(auth('api')->user()->id);
            
            if(!empty($userAuth)) {
                $this->responseCode = 200;
                $this->responseMessage = 'User berhasil ditampilkan';
                $this->responseData['user'] = new UserResource($userAuth);
            }
            else {
                $this->responseCode = 400;
                $this->responseMessage = 'User tidak ditemukan';
            }
        }
        catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function logout()
    {
        try {
            auth('api')->invalidate();

            $this->responseCode = 200;
            $this->responseMessage = 'User berhasil logout';
        }
        catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function refresh()
    {
        try {
            $this->responseCode = 200;
            $this->responseMessage = 'Refresh Token berhasil di generate';
            $this->responseData['refresh_token'] = $this->respondWithToken(auth('api')->refresh());
        }
        catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|confirmed',
                'new_password_confirmation' => 'required'
            ];

            $messages = [];

            $attributes = [
                'current_password' => 'Password lama',
                'new_password' => 'Password baru',
                'new_password_confirmation' => 'Konfirmasi password baru'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            
            if($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else {
                $user = User::find(auth('api')->user()->id);

                if(!empty($user)) {
                    if(Hash::check($request->current_password, $user->password)) {
                        $user->password = Hash::make($request->new_password);
                        $user->save();
    
                        $this->responseCode = 200;
                        $this->responseMessage = 'Password berhasil diedit';
                        DB::commit();
                    }
                    else {
                        $this->responseCode = 400;
                        $this->responseMessage = 'Password lama tidak sama dengan password yang sekarang';
                        DB::rollBack();
                    }
                }
                else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'User tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}

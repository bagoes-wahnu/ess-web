<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try
        {
            $data = [
                [
                    'id' => 1,
                    'nama' => 'administrator',
                    'username' => 'admin',
                    'password' => Hash::make(config('myconfig.default_password')),
                    'id_role' => 1,
                    'id_dinas' => null,
                ]
            ];
    
            foreach ($data as $key => $value) {
                $user = User::withoutGlobalScopes(['isActive', 'checkRelationIsActive'])->find($value['id']);
    
                if(empty($user))
                {
                    $user = new User();
                }
    
                $user->id = $value['id'];
                $user->nama = $value['nama'];
                $user->username = $value['username'];
                $user->password = $value['password'];
                $user->id_role = $value['id_role'];
                $user->id_dinas = $value['id_dinas'];
                $user->save();
            }
            
            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
			echo $ex->getMessage();
        }
    }
}

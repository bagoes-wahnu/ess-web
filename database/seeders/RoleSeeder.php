<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Role;

class RoleSeeder extends Seeder
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
                    'nama' => 'Administrator'
                ],
                [
                    'id' => 2,
                    'nama' => 'Kasie'
                ],
                [
                    'id' => 3,
                    'nama' => 'Kabid'
                ],
                [
                    'id' => 4,
                    'nama' => 'Sekretaris'
                ],
                [
                    'id' => 5,
                    'nama' => 'Kadis'
                ],
                [
                    'id' => 6,
                    'nama' => 'Rayon'
                ],
                [
                    'id' => 7,
                    'nama' => 'BPN'
                ],
                [
                    'id' => 8,
                    'nama' => 'Bagian Hukum'
                ],
                [
                    'id' => 9,
                    'nama' => 'DPBT'
                ],
                [
                    'id' => 10,
                    'nama' => 'DPUBMP'
                ],
                [
                    'id' => 11,
                    'nama' => 'DKRTH'
                ]
            ];
    
            foreach ($data as $key => $value) {
                $role = Role::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($role))
                {
                    $role = new Role();
                }
    
                $role->id = $value['id'];
                $role->nama = $value['nama'];
                $role->save();
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

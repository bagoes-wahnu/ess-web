<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\BerkasKonsep;

class BerkasKonsepSeeder extends Seeder
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
                    'nama' => 'Konsep BAST Administrasi PSU',
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 2,
                    'nama' => 'Surat Perjanjian',
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 3,
                    'nama' => 'Surat Kuasa',
                    'is_bast_admin' => true,
                    'is_bast_fisik' => false
                ],
                [
                    'id' => 4,
                    'nama' => 'Konsep BA Verifikasi',
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ],
                [
                    'id' => 5,
                    'nama' => 'BAST Fisik',
                    'is_bast_admin' => false,
                    'is_bast_fisik' => true
                ]
            ];
    
            foreach ($data as $key => $value) {
                $berkasKonsep = BerkasKonsep::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($berkasKonsep))
                {
                    $berkasKonsep = new BerkasKonsep();
                }
    
                $berkasKonsep->id = $value['id'];
                $berkasKonsep->nama = $value['nama'];
                $berkasKonsep->is_bast_admin = $value['is_bast_admin'];
                $berkasKonsep->is_bast_fisik = $value['is_bast_fisik'];
                $berkasKonsep->save();
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

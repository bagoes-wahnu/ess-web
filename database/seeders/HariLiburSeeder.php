<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\HariLibur;

class HariLiburSeeder extends Seeder
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
                    'nama' => 'Hari Libur Nasional 1',
                    'tanggal_awal' => '2021-08-01',
                    'tanggal_akhir' => '2021-08-31'
                ],
                [
                    'id' => 2,
                    'nama' => 'Hari Libur Nasional 2',
                    'tanggal_awal' => '2021-09-01',
                    'tanggal_akhir' => '2021-09-30'
                ]
            ];
    
            foreach ($data as $key => $value) {
                $hariLibur = HariLibur::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($hariLibur))
                {
                    $hariLibur = new HariLibur();
                }
    
                $hariLibur->id = $value['id'];
                $hariLibur->nama = $value['nama'];
                $hariLibur->tanggal_awal = $value['tanggal_awal'];
                $hariLibur->tanggal_akhir = $value['tanggal_akhir'];
                $hariLibur->save();
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

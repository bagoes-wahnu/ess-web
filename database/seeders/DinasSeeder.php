<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Dinas;

class DinasSeeder extends Seeder
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
                    'nama' => 'DPRKPCKTR',
                    'telepon' => '085763784767',
                    'alamat' => 'Jl Buntu',
                    'id_ssw' => 1
                ],
                [
                    'id' => 2,
                    'nama' => 'Bagian Hukum',
                    'telepon' => '087387689487',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 2
                ],
                [
                    'id' => 3,
                    'nama' => 'DPBT',
                    'telepon' => '087365783767',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 3
                ],
                [
                    'id' => 4,
                    'nama' => 'DPUBMP',
                    'telepon' => '087365783767',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 4
                ],
                [
                    'id' => 5,
                    'nama' => 'DKRTH',
                    'telepon' => '087365783767',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 5
                ],
                [
                    'id' => 6,
                    'nama' => 'DPMPTSP',
                    'telepon' => '087365783767',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 6
                ],
                [
                    'id' => 7,
                    'nama' => 'DLH',
                    'telepon' => '087365783767',
                    'alamat' => 'Jl Pafing',
                    'id_ssw' => 7
                ],
            ];
    
            foreach ($data as $key => $value) {
                $dinas = Dinas::withoutGlobalScope('isActive')->find($value['id']);
    
                if(empty($dinas))
                {
                    $dinas = new Dinas();
                }
    
                $dinas->id = $value['id'];
                $dinas->nama = $value['nama'];
                $dinas->telepon = $value['telepon'];
                $dinas->alamat = $value['alamat'];
                $dinas->id_ssw = $value['id_ssw'];
                $dinas->save();
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

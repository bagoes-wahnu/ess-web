<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermohonanSswPersyaratanFileSeeder extends Seeder
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
            DB::unprepared("INSERT INTO public.permohonan_ssw_persyaratan_file (id_permohonan,id_berkas,nama,\"path\",ukuran,ext,is_gambar) VALUES
            (1,5,'tes','tes',100.0,'png',true),
            (1,354,'tes2','tes2',110.0,'pdf',false),
            (2,5,'tes','tes',100.0,'png',true),
            (2,354,'tes2','tes2',110.0,'pdf',false),
            (3,5,'tes','tes',100.0,'png',true),
            (3,354,'tes2','tes2',110.0,'pdf',false),
            (4,5,'tes','tes',100.0,'png',true),
            (4,354,'tes2','tes2',110.0,'pdf',false),
            (5,5,'tes','tes',100.0,'png',true),
            (5,354,'tes2','tes2',110.0,'pdf',false);
            INSERT INTO public.permohonan_ssw_persyaratan_file (id_permohonan,id_berkas,nama,\"path\",ukuran,ext,is_gambar) VALUES
            (6,5,'tes','tes',100.0,'png',true),
            (6,354,'tes2','tes2',110.0,'pdf',false);");

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
			echo $ex->getMessage();
        }
    }
}

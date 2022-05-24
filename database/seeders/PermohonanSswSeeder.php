<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermohonanSswSeeder extends Seeder
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
            DB::unprepared("INSERT INTO public.permohonan_ssw (id_induk,tanggal_permohonan,nomor_permohonan,nama_subjek,nama_perumahan,lampiran,perihal,id_kecamatan,id_kelurahan,nomor_skrk,tanggal_skrk,nomor_lampiran_gambar,atas_nama,alamat,nama_perusahaan,nama_pemohon,jabatan_pada_perusahaan,luas_lahan_pengembangan,luas_prasarana_jalan_saluran,luas_sarana_fasilitas_umum,luas_sarana_rth,status,is_penarikan_psu,alamat_perumahan,jenis_kegiatan,id_provinsi,id_kabupaten) VALUES
            (NULL,'2021-09-22','123456','tes','tes',1,'tes',12,1004,'123456','2021-09-22','123456','tes','tes','tes','tes','tes',10.0,10.0,10.0,10.0,1,false,'tes','tes',35,78),
            (NULL,'2021-09-23','123457','tes2','tes2',2,'tes2',12,1004,'123457','2021-09-23','123457','tes2','tes2','tes2','tes2','tes2',20.0,20.0,20.0,20.0,1,false,'tes2','tes2',35,78),
            (NULL,'2021-09-24','123458','tes3','tes3',3,'tes3',12,1004,'123458','2021-09-24','123458','tes3','tes3','tes3','tes3','tes3',30.0,30.0,30.0,30.0,1,false,'tes3','tes3',35,78),
            (NULL,'2021-09-22','123459','tes','tes',1,'tes',28,1002,'123459','2021-09-22','123459','tes','tes','tes','tes','tes',10.0,10.0,10.0,10.0,2,false,'tes','tes',35,78),
            (NULL,'2021-09-23','123460','tes2','tes2',2,'tes2',28,1002,'123460','2021-09-23','123460','tes2','tes2','tes2','tes2','tes2',20.0,20.0,20.0,20.0,2,false,'tes2','tes2',35,78),
            (NULL,'2021-09-24','123461','tes3','tes3',3,'tes3',28,1002,'123461','2021-09-24','123461','tes3','tes3','tes3','tes3','tes3',30.0,30.0,30.0,30.0,2,false,'tes3','tes3',35,78);");

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
			echo $ex->getMessage();
        }
    }
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ReportController;

Route::get('/home', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('login');
});

Route::get('struktur-jabatan', function () {
    return view('struktur-jabatan.grid');
});

Route::get('poin-karyawan', function () {
    return view('poin-karyawan.grid');
});

Route::get('lokasi-kantor', function () {
    return view('lokasi-kantor.grid');
});


// Route::group(['prefix' => 'master'], function (){

    
//     Route::get('dinas', function () {
//         return view('master.dinas');
//     });

//     Route::get('berkas', function () {
//         return view('master.berkas');
//     });

//     Route::get('hari-libur', function () {
//         return view('master.hari-libur');
//     });

//     Route::get('user', function () {
//         return view('master.user');
//     });
// });



Route::get('pengajuan-cuti', function () {
    return view('pengajuan-cuti.grid');
});

Route::get('karyawan', function () {
    return view('karyawan.grid');
});

Route::group(['prefix' => 'setting-kpi'], function (){
    Route::get('/', function () {
        return view('setting-kpi.grid');
    });

    Route::get('/{id}', function ($id) {
        return view('setting-kpi.detail',['id'=>$id]);
    });
    
});



Route::get('setting-indikator-perilaku', function () {
    return view('setting-indikator-perilaku.grid');
});

Route::get('setting-izin', function () {
    return view('setting-izin.setting-izin');
});

Route::get('setting-target-poin', function () {
    return view('setting-target-poin.setting-target-poin');
});

Route::get('cetak', function () {
    return view('page.cetak');
});

Route::get('laporan-performa', function () {
    return view('laporan-performa');
});

Route::get('setting-ttd', function () {
    return view('setting-ttd');
});

#REPORT
Route::get('cetak/spd', function () {
    return view('cetakan.spd');
});

Route::get('cetak/pemeriksaan-kesehatan', function () {
    return view('cetakan.pemeriksaan');
});

Route::get('cetak/surat-cuti', function () {
    return view('cetakan.surat-cuti-view');
});

Route::get('/cetak/surat-cuti/download', [ReportController::class, 'suratCuti']);

Route::get('cetak/surat-lembur', function () {
    return view('cetakan.surat-lembur-view');
});

Route::get('/cetak/surat-lembur/download', [ReportController::class, 'suratLembur']);

Route::get('cetak/spjpk', function () {
    return view('cetakan.spjpk-view');
});
Route::get('/cetak/spjpk/download', [ReportController::class, 'spjpk']); //'App\Http\Controllers\ReportController@spjpk');

#INSTANSI
Route::get('instansi', function () {
    return view('instansi.grid');
});

#DIVISI
Route::get('divisi', function () {
    return view('divisi.grid');
});

Route::get('divisi/karyawan/{id_divisi}', function ($id_divisi) {
    return view('divisi.karyawan',['id_divisi'=>$id_divisi]);
});

#INDIKATOR KPI
Route::get('indikator-kpi', function () {
    return view('indikator-kpi.grid');
});

#INDIKATOR PERILAKU
Route::get('indikator-perilaku', function () {
    return view('indikator-perilaku.grid');
});

#PARAMETER NILAI
Route::get('parameter-nilai', function () {
    return view('parameter-nilai.grid');
});


#INDIKATOR
Route::get('iku', function () {
    return view('indikator-kinerja.iku');
});

Route::get('skk', function () {
    return view('indikator-kinerja.skk');
});


#TAHUN
Route::get('tahun', function () {
    return view('tahun.grid');
});

Route::get('tahun/divisi/{id}', function ($id) {
    return view('tahun.divisi-by-tahun',["id"=>$id]);
});

Route::get('tahun/target-nilai/{id1}/{id2}', function ($id1,$id2) {
    return view('tahun.target-nilai',["id1"=>$id1,"id2"=>$id2]);
});

#SETTING SKOR
Route::get('setting-skor', function () {
    return view('setting-skor.grid');
});


#PERMOHONAN IZIN
Route::get('permohonan-izin', function () {
    return view('permohonan-izin.grid');
});

Route::get('permohonan-izin/{id}', function ($id) {
    return view('permohonan-izin.cetak',["id"=>$id]);
});

#BERITA
Route::get('berita', function () {
    return view('berita.news');
});

Route::get('berita/{id}', function ($id) {
    return view('berita.form',["id"=>$id]);
});

Route::get('berita/{id}/perview', function ($id) {
    return view('berita.detail',["id"=>$id]);
});


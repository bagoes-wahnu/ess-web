<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BerkasController;
use App\Http\Controllers\Api\DinasController;
use App\Http\Controllers\Api\HariLiburController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\BastAdminController;
use App\Http\Controllers\Api\BastFisikController;
use App\Http\Controllers\Api\TtdController;
use App\Http\Controllers\Api\SelectListController;
use App\Http\Controllers\Api\ShowFileController;
use App\Http\Controllers\Api\ImportArsipController;
use App\Http\Controllers\Api\Integrator\KominfoIntegratorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api',
    'middleware' => ['api']
], function () {
    //Auth
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware(['jwt.auth', 'is.actived'])->group(function () {
        //Auth
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/change_password', [AuthController::class, 'changePassword']);
        });

        //Master
        Route::prefix('master')->middleware(['role:1'])->group(function () {
            //Master User
            Route::prefix('user')->group(function () {
                Route::get('/', [UserController::class, 'index']);
                Route::post('/', [UserController::class, 'store']);
                Route::put('/{id}', [UserController::class, 'update']);
                Route::get('/{id}', [UserController::class, 'show']);
                Route::patch('/password_reset/{id}', [UserController::class, 'passwordReset']);
                Route::patch('/change_status/{id}', [UserController::class, 'changeStatus']);
                Route::delete('/{id}', [UserController::class, 'destroy']);
            });
        
            //Master Dinas
            Route::prefix('dinas')->group(function () {
                Route::get('/', [DinasController::class, 'index']);
                Route::post('/', [DinasController::class, 'store']);
                Route::put('/{id}', [DinasController::class, 'update']);
                Route::get('/{id}', [DinasController::class, 'show']);
                Route::patch('/change_status/{id}', [DinasController::class, 'changeStatus']);
                Route::delete('/{id}', [DinasController::class, 'destroy']);
            });
        
            //Master Berkas
            Route::prefix('berkas')->group(function () {
                Route::get('/', [BerkasController::class, 'index']);
                Route::post('/', [BerkasController::class, 'store']);
                Route::post('/{id}', [BerkasController::class, 'store']);
                Route::put('/{id}', [BerkasController::class, 'update']);
                Route::get('/{id}', [BerkasController::class, 'show']);
                Route::patch('/change_status/{id}', [BerkasController::class, 'changeStatus']);
                Route::delete('/{id}', [BerkasController::class, 'destroy']);
            });
        
            //Master Hari Libur
            Route::prefix('hari_libur')->group(function () {
                Route::get('/', [HariLiburController::class, 'index']);
                Route::post('/', [HariLiburController::class, 'store']);
                Route::put('/{id}', [HariLiburController::class, 'update']);
                Route::get('/{id}', [HariLiburController::class, 'show']);
                Route::patch('/change_status/{id}', [HariLiburController::class, 'changeStatus']);
                Route::delete('/{id}', [HariLiburController::class, 'destroy']);
            });

            //Master Kegiatan
            Route::prefix('kegiatan')->group(function () {
                Route::get('/', [KegiatanController::class, 'index']);
                Route::post('/', [KegiatanController::class, 'store']);
                Route::put('/{id}', [KegiatanController::class, 'update']);
                Route::get('/{id}', [KegiatanController::class, 'show']);
                Route::patch('/change_status/{id}', [KegiatanController::class, 'changeStatus']);
                Route::delete('/{id}', [KegiatanController::class, 'destroy']);
            });
        });

        //Permohonan
        Route::prefix('permohonan')->group(function () {
            //BAST Admin
            Route::prefix('bast_admin')->group(function () {
                Route::get('/', [BastAdminController::class, 'index']);
                Route::get('/{id}', [BastAdminController::class, 'show']);
                Route::get('/list_requirement_file/{id}/{id_berkas}', [BastAdminController::class, 'listFileRequirement']);
                Route::get('/timeline/{id}', [BastAdminController::class, 'timeline']);
                
                //Proses approve dan pengembalian permohonan
                Route::post('/approve_or_reject_application/{id}', [BastAdminController::class, 'approveOrRejectApplication'])->middleware(['role:' . config('myconfig.role.verificator')]);
                Route::post('/upload_file_reject_application/{id_permohonan_verifikasi}', [BastAdminController::class, 'uploadFileRejectApplication'])->middleware(['role:' . config('myconfig.role.verificator')]);
                Route::get('/list_approve_or_reject_application/{id}', [BastAdminController::class, 'listApproveOrRejectApplication']);
                
                //Berita acara
                Route::post('/create_event_news/{id}', [BastAdminController::class, 'createEventNews'])->middleware(['role:6']);
                Route::get('/list_event_news/{id}', [BastAdminController::class, 'listEventNews']);
                Route::post('/upload_event_news_file/{id_permohonan_berita_acara}', [BastAdminController::class, 'uploadFileEventNews'])->middleware(['role:6']);
                Route::delete('/delete_event_news_file/{id_permohonan_berita_acara_file}', [BastAdminController::class, 'destroyFileEventNews'])->middleware(['role:6']);
                Route::delete('/delete_event_news/{id_permohonan_berita_acara}', [BastAdminController::class, 'destroyEventNews'])->middleware(['role:6']);

                //Proses menyusun dan revisi konsep
                Route::post('/compose_concept/{id}', [BastAdminController::class, 'composeConcept'])->middleware(['role:6']);
                Route::post('/revision_concept/{id}', [BastAdminController::class, 'revisionConcept'])->middleware(['role:6']);
                Route::get('/list_concept_file/{id}/{id_berkas_konsep}', [BastAdminController::class, 'listFileComposeOrRevisionConcept']);
                Route::get('/list_concept_timeline/{id}/{id_berkas_konsep}', [BastAdminController::class, 'timelineFileComposeOrRevisionConcept']);
                Route::post('/upload_concept_file/{id}/{id_berkas_konsep}', [BastAdminController::class, 'uploadFileComposeOrRevisionConcept'])->middleware(['role:6']);
                Route::delete('/delete_concept_file/{id_permohonan_konsep_file}', [BastAdminController::class, 'destroyFileComposeOrRevisionConcept'])->middleware(['role:6']);

                //Proses approve dan koreksi konsep
                Route::post('/approve_or_correction_concept/{id}', [BastAdminController::class, 'approveOrCorrectionConcept'])->middleware(['role:' . config('myconfig.role.approve_or_correction_concept_admin')]);
                Route::post('/correction_concept/{id_permohonan_koreksi_konsep}', [BastAdminController::class, 'correctionConcept'])->middleware(['role:' . config('myconfig.role.approve_or_correction_concept_admin')]);
                Route::post('/upload_correction_concept_file/{id_permohonan_koreksi_konsep_d}', [BastAdminController::class, 'uploadFileCorrectionConcept'])->middleware(['role:' . config('myconfig.role.approve_or_correction_concept_admin')]);
                Route::get('/list_correction_concept_file/{id_permohonan_koreksi_konsep}/{id_berkas_konsep}', [BastAdminController::class, 'listFileCorrectionConcept']);

                //Proses persetujuan teknis
                Route::post('/approve_technical_approval/{id}', [BastAdminController::class, 'approveTechnicalApproval'])->middleware(['role:6']);
                // Route::post('/upload_technical_approvel_file/{id_permohonan_persetujuan_teknis}', [BastAdminController::class, 'uploadFileTechnicalApproval'])->middleware(['role:6']);
                Route::post('/approve_technical_approval_head/{id}', [BastAdminController::class, 'approveTechnicalApprovalHead'])->middleware(['role:' . config('myconfig.role.head_of_cktr')]);
                Route::get('/list_technical_approval_file/{id}', [BastAdminController::class, 'listFileTechnicalApproval']);
                Route::get('/list_timeline_technical_approval/{id}', [BastAdminController::class, 'timelineTechnicalApproval']);
                Route::get('/report_technical_approval/{id}', [BastAdminController::class, 'reportTechnicalApproval']);
            });

            //BAST Fisik
            Route::prefix('bast_fisik')->group(function () {
                Route::get('/', [BastFisikController::class, 'index']);
                Route::get('/{id}', [BastFisikController::class, 'show']);
                Route::get('/list_requirement_file/{id}/{id_berkas}', [BastFisikController::class, 'listFileRequirement']);
                Route::get('/timeline/{id}', [BastFisikController::class, 'timeline']);

                //Proses approve permohonan
                Route::post('/approve_application/{id}', [BastFisikController::class, 'approveApplication'])->middleware(['role:' . config('myconfig.role.verificator')]);
                Route::get('/list_approve_application/{id}', [BastFisikController::class, 'listApproveApplication']);

                //Proses menyusun survey
                Route::post('/compose_survey/{id}', [BastFisikController::class, 'composeSurvey'])->middleware(['role:' . config('myconfig.role.compose_survey_fisik')]);
                Route::post('/upload_survey_file/{id_permohonan_survey}', [BastFisikController::class, 'uploadFileSurvey'])->middleware(['role:' . config('myconfig.role.compose_survey_fisik')]);

                //Proses evaluasi survey
                Route::post('/approve_or_reject_survey_evaluation/{id}', [BastFisikController::class, 'approveOrRejectSurveyEvaluation'])->middleware(['role:' . config('myconfig.role.verificator')]);
                Route::post('/upload_survey_evaluation_file/{id_permohonan_evaluasi_survey}', [BastFisikController::class, 'uploadFileSurveyEvaluation'])->middleware(['role:' . config('myconfig.role.verificator')]);
                Route::get('/list_approve_or_reject_survey_evaluation/{id}', [BastFisikController::class, 'listApproveOrRejectSurveyEvaluation']);
                
                //Proses menyusun dan revisi konsep
                Route::post('/compose_concept/{id}', [BastFisikController::class, 'composeConcept'])->middleware(['role:6']);
                Route::post('/revision_concept/{id}', [BastFisikController::class, 'revisionConcept'])->middleware(['role:6']);
                Route::get('/list_concept_file/{id}/{id_berkas_konsep}', [BastFisikController::class, 'listFileComposeOrRevisionConcept']);
                Route::get('/list_concept_timeline/{id}/{id_berkas_konsep}', [BastFisikController::class, 'timelineFileComposeOrRevisionConcept']);
                Route::post('/upload_concept_file/{id}/{id_berkas_konsep}', [BastFisikController::class, 'uploadFileComposeOrRevisionConcept'])->middleware(['role:6']);
                Route::delete('/delete_concept_file/{id_permohonan_konsep_file}', [BastFisikController::class, 'destroyFileComposeOrRevisionConcept'])->middleware(['role:6']);

                //Proses approve dan koreksi konsep
                Route::post('/approve_or_correction_concept/{id}', [BastFisikController::class, 'approveOrCorrectionConcept'])->middleware(['role:' . config('myconfig.role.verificator_without_rayon')]);
                Route::post('/correction_concept/{id_permohonan_koreksi_konsep}', [BastFisikController::class, 'correctionConcept'])->middleware(['role:' . config('myconfig.role.verificator_without_rayon')]);
                Route::post('/upload_correction_concept_file/{id_permohonan_koreksi_konsep_d}', [BastFisikController::class, 'uploadFileCorrectionConcept'])->middleware(['role:' . config('myconfig.role.verificator_without_rayon')]);
                Route::get('/list_correction_concept_file/{id_permohonan_koreksi_konsep}/{id_berkas_konsep}', [BastFisikController::class, 'listFileCorrectionConcept']);

                //Proses persetujuan teknis
                Route::post('/approve_technical_approval/{id}', [BastFisikController::class, 'approveTechnicalApproval'])->middleware(['role:6']);
                // Route::post('/upload_technical_approvel_file/{id_permohonan_persetujuan_teknis}', [BastFisikController::class, 'uploadFileTechnicalApproval'])->middleware(['role:6']);
                Route::post('/approve_technical_approval_head/{id}', [BastFisikController::class, 'approveTechnicalApprovalHead'])->middleware(['role:' . config('myconfig.role.head_of_cktr')]);
                Route::get('/list_technical_approval_file/{id}', [BastFisikController::class, 'listFileTechnicalApproval']);
                Route::get('/list_timeline_technical_approval/{id}', [BastFisikController::class, 'timelineTechnicalApproval']);
                Route::get('/report_technical_approval/{id}', [BastFisikController::class, 'reportTechnicalApproval']);
            });
        });

        //Setting
        Route::prefix('setting')->middleware(['role:1'])->group(function () {
            //TTD Kadis
            Route::prefix('ttd')->group(function () {
                Route::get('/', [TtdController::class, 'index']);
                Route::post('/store_or_update', [TtdController::class, 'storeOrUpdate']);
                Route::post('/upload_ttd_file', [TtdController::class, 'uploadTtdFile']);
                Route::post('/upload_stempel_file', [TtdController::class, 'uploadStempelFile']);
            });
        });

        //Select List
        Route::prefix('select_list')->group(function () {
            Route::get('/role', [SelectListController::class, 'role']);
            Route::get('/dinas', [SelectListController::class, 'dinas']);
            Route::get('/kecamatan', [SelectListController::class, 'kecamatan']);
            Route::get('/kelurahan', [SelectListController::class, 'kelurahan']);
            Route::get('/berkas_konsep', [SelectListController::class, 'berkasKonsep']);
            Route::get('/berkas', [SelectListController::class, 'berkas']);
            Route::get('/hari_libur', [SelectListController::class, 'hariLibur']);
            Route::get('/proses_permohonan', [SelectListController::class, 'prosesPermohonan']);
            Route::get('/permohonan_bast_admin_hist/{id_induk_awal}', [SelectListController::class, 'permohonanBastAdminHist']);
            Route::get('/permohonan_bast_admin_fisik/{id_induk_fisik_awal}', [SelectListController::class, 'permohonanBastFisikHist']);
        });

        //Show File
        Route::prefix('show_file')->group(function() {
            Route::get('/{transaction}/{id}', [ShowFileController::class, 'index']);
        });
    });
});

        
//Import Arsip
Route::prefix('import_arsip')->group(function () {
    Route::get('/', [ImportArsipController::class, 'index']);
    Route::get('/berkas', [ImportArsipController::class, 'berkas']);
    Route::get('/dinas', [ImportArsipController::class, 'dinas']);
    Route::get('/hari_libur', [ImportArsipController::class, 'hari_libur']);
    Route::get('/kecamatan', [ImportArsipController::class, 'kecamatan']);
    Route::get('/kelurahan', [ImportArsipController::class, 'kelurahan']);
});


Route::group(['middleware' => 'TokenStatis.verify'], function () {

    Route::prefix('psu-master')->group(function () {

        Route::post('/dinas', [DinasController::class, 'storeByArsip']);
        Route::post('/dinas/{id}', [DinasController::class, 'updateByArsip']);

        Route::post('/hari-libur', [HariLiburController::class, 'storeByArsip']);
        Route::post('/hari-libur/{id}', [HariLiburController::class, 'updateByArsip']);

        Route::post('/berkas', [BerkasController::class, 'storeByArsip']);
        Route::post('/berkas/{id}', [BerkasController::class, 'updateByArsip']);

        Route::post('/kecamatan', [DinasController::class, 'storeByArsip']);
        Route::post('/kecamatan/{id}', [DinasController::class, 'updateByArsip']);
        
        Route::post('/kelurahan', [DinasController::class, 'storeByArsip']);
        Route::post('/kelurahan/{id}', [DinasController::class, 'updateByArsip']);

    });

    Route::prefix('integrator')->group(function () {
        Route::prefix('kominfo')->group(function () {
            Route::post('/status_bast', [KominfoIntegratorController::class, 'statusBast']);
        });
    });
});

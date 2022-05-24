<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use Carbon\Carbon;
use App\Helpers\HelperPublic;
use App\Models\Permohonan;
use App\Models\User;
use App\Mail\LateNotifBASTAdmin as LateNotifBASTAdminMail;

class LateNotifBASTAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'latenotif:bast_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk mengirim notifikasi pemberitahuan keterlambatan rayon dalam menyusun/revisi konsep BAST Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(filter_var(config('myconfig.scheduler.late_notif_admin'), FILTER_VALIDATE_BOOLEAN) == true)
        {
            DB::beginTransaction();
            try
            {
                $permohonan = Permohonan::with(['permohonan_histori_penyelesaian_last.proses_permohonan'])
                ->where(function($query) {
                    $query->where(function($query) {
                        $query->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                            $query->where('jenis_bast', 1);
                            $query->whereHas('proses_permohonan', function($query) {
                                $query->whereIn('id', [3, 5, 6]);
                                $query->where('jenis', 1);
                            });
                        });
                    });
                })->where('is_bast_admin', true)->get();

                foreach($permohonan as $key => $value)
                {
                    if(isset($value->permohonan_histori_penyelesaian_last->proses_permohonan))
                    {
                        if($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 3)
                        {
                            $this->lateNotifComposeConcept($value);
                        }
                        elseif($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 5)
                        {
                            $this->lateNotifRevisionConcept($value);
                        }
                        elseif($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 6)
                        {
                            $this->lateNotifTechnicalApproval($value);
                        }
                    }
                }

                DB::commit();
                $this->info('Email Notifikasi Keterlambatan BAST Admin Berhasil Terkirim');
            }
            catch (\Exception $ex)
            {
                DB::rollBack();
                $this->error($ex->getMessage());
            }
        }
        else
        {
            $this->info('Scheduler LateNotifBASTAdmin tidak aktif');
        }
    }

    private function lateNotifComposeConcept($permohonan)
    {
        $permohonanHist = $permohonan->permohonan_histori_penyelesaian_last;
        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
        $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

        // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
        if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5) {
            $user = User::where('id_role', 6)->where(function($query) use ($permohonan) {
                $query->where(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->whereHas('kelurahan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kelurahan);
                    });
                });
    
                $query->orWhere(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->doesntHave('kelurahan');
                });
            })->get();
    
            foreach($user as $key => $value)
            {
                $subject = 'Pemberitahuan Keterlambatan Penyusunan Konsep BAST Admin';
                $view = 'mail.bast-admin.latenotif-bast-admin-compose-concept';
    
                Mail::send(new LateNotifBASTAdminMail($value, $subject, $view, $permohonan));
            }
        }
    }

    private function lateNotifRevisionConcept($permohonan)
    {
        $permohonanHist = $permohonan->permohonan_histori_penyelesaian_last;
        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
        $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

        // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
        if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5) {
            $user = User::where('id_role', 6)->where(function($query) use ($permohonan) {
                $query->where(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->whereHas('kelurahan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kelurahan);
                    });
                });
    
                $query->orWhere(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->doesntHave('kelurahan');
                });
            })->get();
    
            foreach($user as $key => $value)
            {
                $subject = 'Pemberitahuan Keterlambatan Revisi Konsep BAST Admin';
                $view = 'mail.bast-admin.latenotif-bast-admin-revision-concept';
    
                Mail::send(new LateNotifBASTAdminMail($value, $subject, $view, $permohonan));
            }
        }
    }

    private function lateNotifTechnicalApproval($permohonan)
    {
        $permohonanHist = $permohonan->permohonan_histori_penyelesaian_last;
        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
        $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

        // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
        if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5) {
            $user = User::where('id_role', 6)->where(function($query) use ($permohonan) {
                $query->where(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->whereHas('kelurahan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kelurahan);
                    });
                });
    
                $query->orWhere(function($query) use ($permohonan) {
                    $query->whereHas('kecamatan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id_kecamatan);
                    })->doesntHave('kelurahan');
                });
            })->get();
    
            foreach($user as $key => $value)
            {
                $subject = 'Pemberitahuan Keterlambatan Persetujuan Teknis BAST Admin';
                $view = 'mail.bast-admin.latenotif-bast-admin-technical-approval';
    
                Mail::send(new LateNotifBASTAdminMail($value, $subject, $view, $permohonan));
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use App\Helpers\HelperPublic;
use App\Models\Dinas;
use App\Models\Permohonan;
use App\Models\PermohonanVerifikasi;
use App\Models\PermohonanHistoriPenyelesaian;
use App\Models\PermohonanTimeline;
use App\Models\PermohonanKoreksiKonsep;

class AutoApproveBASTAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoapprove:bast_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk auto approve data BAST Admin jika melewati batas waktu';

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
        if(filter_var(config('myconfig.scheduler.auto_approve_admin'), FILTER_VALIDATE_BOOLEAN) == true)
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
                                $query->whereIn('id', [2, 4]);
                                $query->where('jenis', 1);
                            });
                        });
                    });
                    
                    // $query->orWhere(function($query) {
                    //     $query->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                    //         $query->where('jenis_bast', 1);
                    //         $query->whereHas('proses_permohonan', function($query) {
                    //             $query->where('id', 6);
                    //             $query->where('jenis', 1);
                    //         });
                    //     });
                    //     $query->whereHas('permohonan_persetujuan_teknis', function($query) {
                    //         $query->where('jenis_bast', 1);
                    //     });
                    // });
                })->where('is_bast_admin', true)->get();

                foreach($permohonan as $key => $value)
                {
                    if(isset($value->permohonan_histori_penyelesaian_last->proses_permohonan))
                    {
                        if($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 2)
                        {
                            $this->approveOrRejectApplication($value);
                        }
                        elseif($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 4)
                        {
                            $this->approveOrCorrectionConcept($value);
                        }
                        // elseif($value->permohonan_histori_penyelesaian_last->proses_permohonan->id == 6)
                        // {
                        //     $this->approveTechnicalApprovalHead($value);
                        // }
                    }
                }

                DB::commit();
                $this->info('Auto Approve Data BAST Admin Berhasil Dijalankan');
            }
            catch (\Exception $ex)
            {
                DB::rollBack();
                $this->error($ex->getMessage());
            }
        }
        else
        {
            $this->info('Scheduler AutoApproveBASTAdmin tidak aktif');
        }
    }

    private function approveOrRejectApplication($permohonan)
    {
        $containRejectCount = PermohonanVerifikasi::whereHas('permohonan', function($query) use ($permohonan) {
            $query->where('id', $permohonan->id);
            $query->where('is_bast_admin', true);
        })
        ->whereHas('dinas.user', function($query) use ($permohonan) {
            $query->where(function($query) use ($permohonan) {
                $query->whereHas('role', function($query) {
                    $query->whereIn('id', HelperPublic::roleAsVerificatorWithLocation());
                });

                $query->where(function($query) use ($permohonan) {
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

                    $query->orWhere(function($query) use ($permohonan) {
                        $query->doesntHave('kecamatan')
                        ->whereHas('kelurahan', function($query) use ($permohonan) {
                            $query->where('id', $permohonan->id_kelurahan);
                        });
                    });
                });
            })
            ->orWhere(function($query) {
                $query->whereHas('role', function($query) {
                    $query->whereIn('id', HelperPublic::roleAsVerificatorWithoutLocation());
                });

                $query->where(function($query) {
                    $query->doesntHave('kecamatan');
                    $query->doesntHave('kelurahan');
                });
            });
        })
        ->where('jenis_bast', 1)->where('status', 2)->count();
        
        $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
            $query->where('jenis', 1);
        }])
        ->where('id', $permohonan->id_permohonan_histori_penyelesaian)
        ->where('jenis_bast', 1)->first();

        if(!empty($permohonanHist))
        {
            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
            $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

            // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
            if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5)
            {
                $dinas = Dinas::whereHas('user', function($query) use ($permohonan) {
                    $query->where(function($query) use ($permohonan) {
                        $query->whereHas('role', function($query) {
                            $query->whereIn('id', HelperPublic::roleAsVerificatorWithLocation());
                        });
        
                        $query->where(function($query) use ($permohonan) {
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
        
                            $query->orWhere(function($query) use ($permohonan) {
                                $query->doesntHave('kecamatan')
                                ->whereHas('kelurahan', function($query) use ($permohonan) {
                                    $query->where('id', $permohonan->id_kelurahan);
                                });
                            });
                        });
                    })
                    ->orWhere(function($query) {
                        $query->whereHas('role', function($query) {
                            $query->whereIn('id', HelperPublic::roleAsVerificatorWithoutLocation());
                        });
        
                        $query->where(function($query) {
                            $query->doesntHave('kecamatan');
                            $query->doesntHave('kelurahan');
                        });
                    });
                })->get();
        
                foreach($dinas as $key => $value)
                {
                    $permohonanVerifikasi = new PermohonanVerifikasi();
                    $permohonanVerifikasi->status = 1;
                    $permohonanVerifikasi->id_permohonan = $permohonan->id;
                    $permohonanVerifikasi->id_dinas = $value->id;
                    $permohonanVerifikasi->jenis_bast = 1;
                    $permohonanVerifikasi->is_otomatis = true;
                    $permohonanVerifikasi->save();
                }

                $permohonanHist->jumlah_hari = $jumlahHari;

                if($containRejectCount > 0)
                {
                    $permohonanHist->is_pengembalian = true;
                }

                $permohonanHist->save();

                if($containRejectCount == 0)
                {
                    $permohonanHist = new PermohonanHistoriPenyelesaian();
                    $permohonanHist->id_permohonan = $permohonan->id;
                    $permohonanHist->id_proses_permohonan = 3;
                    $permohonanHist->jenis_bast = 1;
                    $permohonanHist->save();
                    
                    $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                    $permohonan->save();

                    PermohonanTimeline::storeTimeline($permohonan->id, 3, 1);
                }
                else
                {
                    DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
                    ->update(['status' => 3, 'is_penarikan_psu' => false]);

                    PermohonanTimeline::storeTimeline($permohonan->id, 2, 1);
                }
            }
        }
        else
        {
            throw new \Exception('Data permohonan histori penyelesaian terakhir tidak ditemukan');
        }
    }

    private function approveOrCorrectionConcept($permohonan)
    {
        $containCorrectionCount = PermohonanKoreksiKonsep::whereHas('permohonan', function($query) use ($permohonan) {
            $query->where('id', $permohonan->id);
            $query->where('is_bast_admin', true);
        })->whereHas('dinas.user.role', function($query) {
            $query->whereIn('id', HelperPublic::roleAsApproveAndCorrectionConceptAdmin());
        })->where('status', 2)->where('jenis_bast', 1)->count();

        $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
            $query->where('jenis', 1);
        }])
        ->where('id', $permohonan->id_permohonan_histori_penyelesaian)
        ->where('jenis_bast', 1)->first();

        if(!empty($permohonanHist))
        {
            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
            $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

            // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
            if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5)
            {
                $permohonanHist->jumlah_hari = $jumlahHari;
                $permohonanHist->save();

                $permohonanHist = new PermohonanHistoriPenyelesaian();
                $permohonanHist->id_permohonan = $permohonan->id;
                $permohonanHist->id_proses_permohonan = ($containCorrectionCount > 0) ? 5 : 6;
                $permohonanHist->jenis_bast = 1;
                $permohonanHist->save();
                    
                $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                $permohonan->save();

                PermohonanTimeline::storeTimeline($permohonan->id, (($containCorrectionCount > 0) ? 5 : 6), 1);
            }
        }
        else
        {
            throw new \Exception('Data permohonan histori penyelesaian terakhir tidak ditemukan');
        }
    }

    // private function approveTechnicalApprovalHead($permohonan)
    // {
    //     $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
    //         $query->where('jenis', 1);
    //     }])
    //     ->where('id', $permohonan->id_permohonan_histori_penyelesaian)
    //     ->where('jenis_bast', 1)->first();

    //     if(!empty($permohonanHist))
    //     {
    //         $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
    //         $jumlahMenit = $permohonanHist->created_at->diffInMinutes(Carbon::now());

    //         // if(!empty($permohonanHist->proses_permohonan) && $permohonanHist->proses_permohonan->batas_waktu < $jumlahHari)
    //         if(!empty($permohonanHist->proses_permohonan) && $jumlahMenit >= 5)
    //         {
    //             $permohonanHist->jumlah_hari = $jumlahHari;
    //             $permohonanHist->save();

    //             $permohonanHist = new PermohonanHistoriPenyelesaian();
    //             $permohonanHist->id_permohonan = $permohonan->id;
    //             $permohonanHist->id_proses_permohonan = 7;
    //             $permohonanHist->jenis_bast = 1;
    //             $permohonanHist->save();
                    
    //             $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
    //             $permohonan->save();

    //             PermohonanTimeline::storeTimeline($permohonan->id, 9, 1);

    //             DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
    //             ->update(['status' => 2, 'is_penarikan_psu' => false]);   
    //         }
    //     }
    //     else
    //     {
    //         throw new \Exception('Data permohonan histori penyelesaian terakhir tidak ditemukan');
    //     }
    // }
}

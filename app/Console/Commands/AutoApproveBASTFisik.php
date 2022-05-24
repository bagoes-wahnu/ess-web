<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use App\Helpers\HelperPublic;
use App\Models\Dinas;
use App\Models\Permohonan;
use App\Models\PermohonanVerifikasi;
use App\Models\PermohonanEvaluasiSurvey;
use App\Models\PermohonanHistoriPenyelesaian;
use App\Models\PermohonanTimeline;
use App\Models\PermohonanKoreksiKonsep;

class AutoApproveBASTFisik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoapprove:bast_fisik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk auto approve data BAST Fisik jika melewati batas waktu';

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
        if(filter_var(config('myconfig.scheduler.auto_approve_fisik'), FILTER_VALIDATE_BOOLEAN) == true)
        {
            DB::beginTransaction();
            try
            {
                $permohonan = Permohonan::with(['permohonan_fisik_histori_penyelesaian_last.proses_permohonan'])
                ->where(function($query) {
                    $query->where(function($query) {
                        $query->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                            $query->where('jenis_bast', 2);
                            $query->whereHas('proses_permohonan', function($query) {
                                $query->whereIn('id', [9, 11, 13]);
                                $query->where('jenis', 2);
                            });
                        });
                    });
                    
                    // $query->orWhere(function($query) {
                    //     $query->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    //         $query->where('jenis_bast', 2);
                    //         $query->whereHas('proses_permohonan', function($query) {
                    //             $query->where('id', 15);
                    //             $query->where('jenis', 2);
                    //         });
                    //     });
                    //     $query->whereHas('permohonan_persetujuan_teknis', function($query) {
                    //         $query->where('jenis_bast', 2);
                    //     });
                    // });
                })->where('is_bast_fisik', true)->get();

                foreach($permohonan as $key => $value)
                {
                    if(isset($value->permohonan_fisik_histori_penyelesaian_last->proses_permohonan))
                    {
                        if($value->permohonan_fisik_histori_penyelesaian_last->proses_permohonan->id == 9)
                        {
                            $this->approveApplication($value);
                        }
                        elseif($value->permohonan_fisik_histori_penyelesaian_last->proses_permohonan->id == 11)
                        {
                            $this->approveOrRejectSurveyEvaluation($value);
                        }
                        elseif($value->permohonan_fisik_histori_penyelesaian_last->proses_permohonan->id == 13)
                        {
                            $this->approveOrCorrectionConcept($value);
                        }
                        // elseif($value->permohonan_fisik_histori_penyelesaian_last->proses_permohonan->id == 15)
                        // {
                        //     $this->approveTechnicalApprovalHead($value);
                        // }
                    }
                }

                DB::commit();
                $this->info('Auto Approve Data BAST Fisik Berhasil Dijalankan');
            }
            catch (\Exception $ex)
            {
                DB::rollBack();
                $this->error($ex->getMessage());
            }
        }
        else
        {
            $this->info('Scheduler AutoApproveBASTFisik tidak aktif');
        }
    }

    private function approveApplication($permohonan)
    {
        $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
            $query->where('jenis', 2);
        }])
        ->where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
        ->where('jenis_bast', 2)->first();

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
                    $permohonanVerifikasi->jenis_bast = 2;
                    $permohonanVerifikasi->is_otomatis = true;
                    $permohonanVerifikasi->save();
                }

                $permohonanHist->jumlah_hari = $jumlahHari; 
                $permohonanHist->save();

                $permohonanHist = new PermohonanHistoriPenyelesaian();
                $permohonanHist->id_permohonan = $permohonan->id;
                $permohonanHist->id_proses_permohonan = 10;
                $permohonanHist->jenis_bast = 2;
                $permohonanHist->save();
                
                $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                $permohonan->save();

                PermohonanTimeline::storeTimeline($permohonan->id, 2, 2);
            }
        }
        else
        {
            throw new \Exception('Data permohonan histori penyelesaian terakhir tidak ditemukan');
        }
    }

    private function approveOrRejectSurveyEvaluation($permohonan)
    {
        $containRejectCount = PermohonanEvaluasiSurvey::whereHas('permohonan', function($query) use ($permohonan) {
            $query->where('id', $permohonan->id);
            $query->where('is_bast_fisik', true);
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
        ->where('status', 2)->count();

        $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
            $query->where('jenis', 2);
        }])
        ->where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
        ->where('jenis_bast', 2)->first();

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
                    $permohonanEvaluasiSurvey = new PermohonanEvaluasiSurvey();
                    $permohonanEvaluasiSurvey->status = 1;
                    $permohonanEvaluasiSurvey->id_permohonan = $permohonan->id;
                    $permohonanEvaluasiSurvey->id_dinas = $dinas->id;
                    $permohonanEvaluasiSurvey->is_otomatis = true;
                    $permohonanEvaluasiSurvey->save();
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
                    $permohonanHist->id_proses_permohonan = 12;
                    $permohonanHist->jenis_bast = 2;
                    $permohonanHist->save();
                    
                    $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                    $permohonan->save();

                    PermohonanTimeline::storeTimeline($permohonan->id, 5, 2);
                }
                else
                {
                    DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
                    ->update(['status' => 4, 'is_penarikan_psu' => false]);

                    PermohonanTimeline::storeTimeline($permohonan->id, 4, 2);
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
            $query->where('is_bast_fisik', true);
        })
        ->whereHas('dinas.user', function($query) use ($permohonan) {
            $query->where(function($query) use ($permohonan) {
                $query->whereHas('role', function($query) {
                    $query->whereIn('id', HelperPublic::roleAsVerificatorWithLocationWithoutRayon());
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
        ->where('status', 2)->where('jenis_bast', 2)->count();

        $permohonanHist = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function ($query) {
            $query->where('jenis', 2);
        }])
        ->where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
        ->where('jenis_bast', 2)->first();

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
                $permohonanHist->id_proses_permohonan = ($containCorrectionCount > 0) ? 14 : 15;
                $permohonanHist->jenis_bast = 2;
                $permohonanHist->save();
                    
                $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                $permohonan->save();

                PermohonanTimeline::storeTimeline($permohonan->id, (($containCorrectionCount > 0) ? 7 : 8), 2);
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
    //         $query->where('jenis', 2);
    //     }])
    //     ->where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
    //     ->where('jenis_bast', 2)->first();

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
    //             $permohonanHist->id_proses_permohonan = 16;
    //             $permohonanHist->jenis_bast = 2;
    //             $permohonanHist->save();
                    
    //             $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
    //             $permohonan->save();

    //             PermohonanTimeline::storeTimeline($permohonan->id, 11, 2);

    //             DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
    //             ->update(['status' => 5, 'is_penarikan_psu' => false]);
    //         }
    //     }
    //     else
    //     {
    //         throw new \Exception('Data permohonan histori penyelesaian terakhir tidak ditemukan');
    //     }
    // }
}

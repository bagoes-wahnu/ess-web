<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\Helpers\HelperPublic;
use App\Models\User;
use App\Models\Dinas;
use App\Models\Ttd;
use App\Models\ProsesPermohonan;
use App\Models\Permohonan;
use App\Models\PermohonanPersyaratanFile;
use App\Models\PermohonanTimeline;
use App\Models\PermohonanVerifikasi;
use App\Models\PermohonanVerifikasiFile;
use App\Models\PermohonanSurvey;
use App\Models\PermohonanSurveyFile;
use App\Models\PermohonanEvaluasiSurvey;
use App\Models\PermohonanEvaluasiSurveyFile;
use App\Models\PermohonanKonsepFile;
use App\Models\PermohonanKonsepTimeline;
use App\Models\PermohonanKoreksiKonsep;
use App\Models\PermohonanKoreksiKonsepDetail;
use App\Models\PermohonanKoreksiKonsepDetailFile;
use App\Models\PermohonanPersetujuanTeknis;
use App\Models\PermohonanPersetujuanTeknisFile;
use App\Models\PermohonanPersetujuanTeknisTimeline;
use App\Models\PermohonanHistoriPenyelesaian;
use App\Models\Kecamatan;
use App\Models\Berkas;
use App\Models\BerkasKonsep;
use App\Http\Resources\DinasResource;
use App\Http\Resources\TtdResource;
use App\Http\Resources\PermohonanResource;
use App\Http\Resources\PermohonanPersyaratanFileResource;
use App\Http\Resources\PermohonanTimelineResource;
use App\Http\Resources\PermohonanVerifikasiResource;
use App\Http\Resources\PermohonanVerifikasiFileResource;
use App\Http\Resources\PermohonanSurveyResource;
use App\Http\Resources\PermohonanSurveyFileResource;
use App\Http\Resources\PermohonanEvaluasiSurveyResource;
use App\Http\Resources\PermohonanEvaluasiSurveyFileResource;
use App\Http\Resources\PermohonanKonsepFileResource;
use App\Http\Resources\PermohonanKonsepTimelineResource;
use App\Http\Resources\PermohonanKoreksiKonsepResource;
use App\Http\Resources\PermohonanKoreksiKonsepDetailResource;
use App\Http\Resources\PermohonanKoreksiKonsepDetailFileResource;
use App\Http\Resources\PermohonanPersetujuanTeknisResource;
use App\Http\Resources\PermohonanPersetujuanTeknisFileResource;
use App\Http\Resources\PermohonanPersetujuanTeknisTimelineResource;
use App\Http\Resources\PermohonanHistoriPenyelesaianResource;
use App\Http\Resources\BerkasResource;
use App\Http\Resources\BerkasKonsepResource;

class BastFisikController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $role = $user->role;
        $dinas = $user->dinas;

        $request->merge(['custom_resource' => true, 'role' => $role, 'jenis_bast' => 2]);

        $permohonan = Permohonan::with(['kecamatan', 'kelurahan',
        'permohonan_fisik_histori_penyelesaian_last' => function($query) {
            $query->where('jenis_bast', 2);
            $query->with(['proses_permohonan' => function($query) {
                $query->where('jenis', 2);
            }]);
        }, 'permohonan_verifikasi' => function($query) use ($dinas) {
            $query->where('jenis_bast', 2);
            
            if(!empty($dinas))
            {
                $query->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                });
            }
            else
            {
                $query->whereRaw('1 = 0');
            }
        }, 'permohonan_survey' => function($query) use ($dinas) {
            if(!empty($dinas))
            {
                $query->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                });
            }
            else
            {
                $query->whereRaw('1 = 0');
            }
        }, 'permohonan_evaluasi_survey' => function($query) use ($dinas) {
            if(!empty($dinas))
            {
                $query->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                });
            }
            else
            {
                $query->whereRaw('1 = 0');
            }
        }, 'permohonan_koreksi_konsep' => function($query) use ($dinas) {
            $query->where('jenis_bast', 2);
            
            if(!empty($dinas))
            {
                $query->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                });
            }
            else
            {
                $query->whereRaw('1 = 0');
            }
        }, 'permohonan_persetujuan_teknis' => function($query) {
            $query->where('jenis_bast', 2);
        }]);

        $permohonan = $permohonan->join(DB::raw('(SELECT id_induk_fisik_awal, MAX(permohonan_fisik_ke) AS permohonan_fisik_ke FROM permohonan WHERE is_bast_fisik = true AND deleted_at IS NULL GROUP BY id_induk_fisik_awal) AS permohonan_last'), function($query) {
            $query->on(DB::raw('(permohonan.id_induk_fisik_awal, permohonan.permohonan_fisik_ke)'), DB::raw('(permohonan_last.id_induk_fisik_awal, permohonan_last.permohonan_fisik_ke)'));
        });

        if(in_array($role->id, HelperPublic::roleAsVerificatorWithLocation()))
        {
            $kecamatan = $user->kecamatan->pluck('id');
            $kelurahan = $user->kelurahan->pluck('id');

            if($role->id == 6)
            {
                $permohonan = $permohonan->where(function($query) use ($kecamatan, $kelurahan) {
                    $query->whereRaw('1 = 0');

                    foreach($kecamatan as $key => $value)
                    {
                        $kelurahanSelection = Kecamatan::with(['kelurahan' => function($query) use ($kelurahan) {
                            $query->whereIn('id', $kelurahan);
                        }])->find($value);

                        if(!empty($kelurahanSelection))
                        {
                            $kelurahanFinal = $kelurahanSelection->kelurahan->pluck('id');
                            if(count($kelurahanFinal) > 0)
                            {
                                $query->orWhere(function($query) use ($value, $kelurahanFinal) {
                                    $query->whereHas('kecamatan', function($query) use ($value) {
                                        $query->where('id', $value);
                                    })->whereHas('kelurahan', function($query) use ($kelurahanFinal) {
                                        $query->whereIn('id', $kelurahanFinal);
                                    });
                                });
                            }
                            else
                            {
                                $query->orWhereHas('kecamatan', function($query) use ($value) {
                                    $query->where('id', $value);
                                });
                            }
                        }
                    }
                });
            }

            if($role->id == 7)
            {
                $permohonan = $permohonan->whereHas('kecamatan', function($query) use ($kecamatan) {
                    $query->whereIn('id', $kecamatan);
                });
            }
        }
        else
        {
            if(in_array($role->id, HelperPublic::roleAsHeadOfCKTR()))
            {
                $permohonan = $permohonan->where(function($query) use ($role) {
                    $query->where(function($query) use ($role) {
                        $query->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                            $query->where('jenis_bast', 2);
                            $query->whereHas('proses_permohonan', function($query) {
                                $query->where('id', 15);
                                $query->where('jenis', 2);
                            });
                        })
                        ->whereHas('permohonan_persetujuan_teknis', function($query) use ($role) {
                            $query->where('jenis_bast', 2);
                            if($role->id == 2)
                            {
                                $query->where('status', '>=', 1);
                            }
                            elseif($role->id == 3)
                            {
                                $query->where('status', '>=', 2);
                            }
                            elseif($role->id == 4)
                            {
                                $query->where('status', '>=', 3);
                            }
                            elseif($role->id == 5)
                            {
                                $query->where('status', '>=', 4);
                            }
                            else
                            {
                                $query->whereRaw('1 = 0');
                            }
                        });
                    })
                    ->orWhereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                        $query->whereHas('proses_permohonan', function($query) {
                            $query->where('id', 16);
                            $query->where('jenis', 2);
                        });
                    });
                });
            }
        }

        $permohonan = $permohonan->where('is_bast_fisik', true);
        
        return DataTables::eloquent($permohonan)
        ->setTransformer(function($item) {
            return PermohonanResource::make($item)->resolve();
        })
        ->toJson();
    }
    
    public function show(Request $request, $id)
    {
        try
        {
            $user = auth('api')->user();
            $role = $user->role;
            $dinas = $user->dinas;

            $request->merge(['custom_resource' => true, 'role' => $role, 'jenis_bast' => 2]);

            $permohonan = Permohonan::with(['kecamatan', 'kelurahan',
            'permohonan_fisik_histori_penyelesaian_last' => function($query) {
                $query->where('jenis_bast', 2);
                $query->with(['proses_permohonan' => function($query) {
                    $query->where('jenis', 2);
                }]);
            }, 'permohonan_verifikasi' => function($query) use ($dinas) {
                $query->where('jenis_bast', 2);
                
                if(!empty($dinas))
                {
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            }, 'permohonan_survey' => function($query) use ($dinas) {
                if(!empty($dinas))
                {
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            }, 'permohonan_evaluasi_survey' => function($query) use ($dinas) {
                if(!empty($dinas))
                {
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            }, 'permohonan_koreksi_konsep' => function($query) use ($dinas) {
                $query->where('jenis_bast', 2);
                
                if(!empty($dinas))
                {
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            }, 'permohonan_persetujuan_teknis' => function($query) {
                $query->where('jenis_bast', 2);
            }])
            ->where('is_bast_fisik', true)
            ->where('id', $id)->first();

            if(!empty($permohonan)) 
            {
                //Berkas persyaratan
                $berkas = Berkas::withCount(['permohonan_persyaratan_file' => function($query) use ($id) {
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    });
                }])->where('is_bast_fisik', true)->orderBy('urutan', 'asc')->get();

                //Histori penyelesaian
                $totalHari = ProsesPermohonan::where('jenis', 2)->sum('batas_waktu');
                $realisasiTotalHari = PermohonanHistoriPenyelesaian::whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_fisik', true);
                })->where('jenis_bast', 2)->sum('jumlah_hari');
                $totalHariKeterlambatan = $totalHari - $realisasiTotalHari;

                $permohonanHistoriPenyelesaian = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function($query) {
                    $query->where('jenis', 2);
                }])->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_fisik', true);
                })
                ->where('jenis_bast', 2)->orderBy('id', 'desc')->get();

                $listSurvey = [];

                $dinas = Dinas::whereHas('user.role', function($query) {
                    $query->whereIn('id', HelperPublic::roleAsComposeSurveyFisik());
                })->get();

                foreach($dinas as $key => $value)
                {
                    //Berkas survey
                    $survey = PermohonanSurvey::with(['permohonan_survey_file'])
                    ->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    })
                    ->whereHas('dinas', function($query) use ($value) {
                        $query->where('id', $value->id);
                    })->get();

                    array_push($listSurvey, [
                        'dinas' => new DinasResource($value),
                        'berkas_survey' => PermohonanSurveyResource::collection($survey)
                    ]);
                }

                //Original berkas konsep
                $originalBerkasKonsep = BerkasKonsep::withCount(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 2);
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    });
                }])->where('is_bast_fisik', true)->get();

                $listKoreksiBerkasKonsep = [];

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
                    $permohonanKoreksiKonsep = PermohonanKoreksiKonsep::whereHas('dinas', function($query) use ($value) {
                        $query->where('id', $value->id);
                    })
                    ->where('jenis_bast', 2)
                    ->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    })
                    ->first();

                    //Koreksi berkas konsep
                    $koreksiBerkasKonsep = BerkasKonsep::with(['permohonan_koreksi_konsep_detail' => function($query) use ($id, $value) {
                        $query->withCount('permohonan_koreksi_konsep_detail_file');
                        $query->whereHas('permohonan_koreksi_konsep', function($query) use ($id, $value) {
                            $query->whereHas('dinas', function($query) use ($value) {
                                $query->where('id', $value->id);
                            });
                            $query->where('jenis_bast', 2);
                            $query->whereHas('permohonan', function($query) use ($id) {
                                $query->where('id', $id);
                                $query->where('is_bast_fisik', true);
                            });
                        });
                    }])->where('is_bast_fisik', true)->get();

                    array_push($listKoreksiBerkasKonsep, [
                        'dinas' => new DinasResource($value),
                        'permohonan_koreksi_konsep' => (!empty($permohonanKoreksiKonsep)) ? new PermohonanKoreksiKonsepResource($permohonanKoreksiKonsep) : null,
                        'berkas_konsep' => BerkasKonsepResource::collection($koreksiBerkasKonsep)
                    ]);
                }

                //Revisi berkas konsep
                $revisiBerkasKonsep = BerkasKonsep::withCount(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', true);
                    $query->where('jenis_bast', 2);
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    });
                }])->where('is_bast_fisik', true)->get();

                $this->responseCode = 200;
                $this->responseMessage = 'Data permohonan berhasil ditampilkan';
                $this->responseData['permohonan'] = new PermohonanResource($permohonan);
                $this->responseData['berkas_persyaratan'] = BerkasResource::collection($berkas);
                $this->responseData['survey'] = $listSurvey;
                $this->responseData['konsep_bast']['original_berkas_konsep'] = BerkasKonsepResource::collection($originalBerkasKonsep);
                $this->responseData['konsep_bast']['koreksi_berkas_konsep'] = $listKoreksiBerkasKonsep;
                $this->responseData['konsep_bast']['revisi_berkas_konsep'] = BerkasKonsepResource::collection($revisiBerkasKonsep);
                $this->responseData['histori_penyelesaian']['total_hari'] = $totalHari;
                $this->responseData['histori_penyelesaian']['realisasi_total_hari'] = $realisasiTotalHari;
                $this->responseData['histori_penyelesaian']['total_hari_keterlambatan'] = ($totalHariKeterlambatan < 0) ? abs($totalHariKeterlambatan) : 0;
                $this->responseData['histori_penyelesaian']['data'] = PermohonanHistoriPenyelesaianResource::collection($permohonanHistoriPenyelesaian);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan tidak ditemukan';
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listFileRequirement($id, $id_berkas)
    {
        try
        {
            $permohonanPersyaratanFile = PermohonanPersyaratanFile::whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })
            ->whereHas('berkas', function($query) use ($id_berkas) {
                $query->where('id', $id_berkas);
                $query->where('is_bast_fisik', true);
            })->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan persyaratan file berhasil ditampilkan';
            $this->responseData['permohonan_persyaratan_file'] = PermohonanPersyaratanFileResource::collection($permohonanPersyaratanFile);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function timeline($id)
    {
        try
        {
            $permohonanTimeline = PermohonanTimeline::whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })->where('jenis_bast', 2)->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan timeline berhasil ditampilkan';
            $this->responseData['permohonan_timeline'] = PermohonanTimelineResource::collection($permohonanTimeline);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    //Approve Permohonan
    public function approveApplication(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'catatan' => 'nullable'
            ];

            $messages = [];

            $attributes = [
                'catatan' => 'Catatan'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 9);
                        $query->where('jenis', 2);
                    });
                })
                ->whereDoesntHave('permohonan_verifikasi', function($query) use ($dinas) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('is_bast_fisik', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanVerifikasi = new PermohonanVerifikasi();
                    $permohonanVerifikasi->catatan = $request->catatan;
                    $permohonanVerifikasi->status = 1;
                    $permohonanVerifikasi->id_permohonan = $permohonan->id;
                    $permohonanVerifikasi->id_dinas = $dinas->id;
                    $permohonanVerifikasi->jenis_bast = 2;
                    $permohonanVerifikasi->save();
                    
                    $dinasCount = Dinas::whereHas('user', function($query) use ($permohonan) {
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
                    })->count();

                    $permohonanVerifikasiCount = PermohonanVerifikasi::whereHas('permohonan', function($query) use ($permohonan) {
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
                    ->where('jenis_bast', 2)->count();

                    if($permohonanVerifikasiCount == $dinasCount)
                    {
                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                        ->where('jenis_bast', 2)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
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
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data verifikasi berhasil disimpan';
                    $this->responseData['permohonan_verifikasi'] = new PermohonanVerifikasiResource($permohonanVerifikasi);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listApproveApplication($id)
    {
        try
        {
            $permohonanVerifikasi = PermohonanVerifikasi::with(['dinas'])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })->where('jenis_bast', 2)->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan verifikasi berhasil ditampilkan';
            $this->responseData['permohonan_verifikasi'] = PermohonanVerifikasiResource::collection($permohonanVerifikasi);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Approve Permohonan

    //Menyusun Survey
    public function composeSurvey(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'catatan' => 'nullable'
            ];

            $messages = [];

            $attributes = [
                'catatan' => 'Catatan'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 10);
                        $query->where('jenis', 2);
                    });
                })
                ->whereDoesntHave('permohonan_survey.dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })
                ->where('is_bast_fisik', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanSurvey = new PermohonanSurvey();
                    $permohonanSurvey->id_permohonan = $permohonan->id;
                    $permohonanSurvey->id_dinas = $dinas->id;
                    $permohonanSurvey->catatan = $request->catatan;
                    $permohonanSurvey->save();
                    
                    $dinasCount = Dinas::whereHas('user.role', function($query) {
                        $query->whereIn('id', HelperPublic::roleAsComposeSurveyFisik());
                    })->count();

                    $permohonanSurveyCount = PermohonanSurvey::whereHas('permohonan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id);
                        $query->where('is_bast_fisik', true);
                    })->whereHas('dinas.user.role', function($query) {
                        $query->whereIn('id', HelperPublic::roleAsComposeSurveyFisik());
                    })->count();

                    if($permohonanSurveyCount == $dinasCount)
                    {
                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                        ->where('jenis_bast', 2)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                            $permohonanHist->jumlah_hari = $jumlahHari;
                            $permohonanHist->save();

                            $permohonanHist = new PermohonanHistoriPenyelesaian();
                            $permohonanHist->id_permohonan = $permohonan->id;
                            $permohonanHist->id_proses_permohonan = 11;
                            $permohonanHist->jenis_bast = 2;
                            $permohonanHist->save();
                                
                            $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                            $permohonan->save();

                            PermohonanTimeline::storeTimeline($permohonan->id, 3, 2);
                        }
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data survey berhasil disimpan';
                    $this->responseData['permohonan_survey'] = new PermohonanSurveyResource($permohonanSurvey);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function uploadFileSurvey(Request $request, $id_permohonan_survey)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'array|min:1',
                'file.*' => 'required|file|mimes:pdf'
            ];

            $messages = [];

            $attributes = [
                'file' => 'Unggahan dokumen',
                'file.*' => 'Unggahan dokumen'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonanSurvey = PermohonanSurvey::where('id', $id_permohonan_survey)
                ->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })->first();

                if(!empty($permohonanSurvey))
                {
                    $path = 'bast_fisik/' . $permohonanSurvey->id_permohonan . '/survey/' . $permohonanSurvey->id;

                    if(!empty($request->file))
                    {
                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanSurveyFile = new PermohonanSurveyFile();
                            $permohonanSurveyFile->id_permohonan_survey = $permohonanSurvey->id;
                            $permohonanSurveyFile->nama = $value->getClientOriginalName();
                            $permohonanSurveyFile->path = $path . '/' . $changedName;
                            $permohonanSurveyFile->ukuran = $value->getSize();
                            $permohonanSurveyFile->ext = $value->getClientOriginalExtension();
                            $permohonanSurveyFile->is_gambar = $is_image;
                            $permohonanSurveyFile->save();
                        }
                    }

                    $permohonanSurveyFile = PermohonanSurveyFile::whereHas('permohonan_survey', function($query) use ($permohonanSurvey, $dinas) {
                        $query->where('id', $permohonanSurvey->id);
                        $query->whereHas('dinas', function($query) use ($dinas) {
                            $query->where('id', $dinas->id);
                        });
                    })->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_survey_file'] = PermohonanSurveyFileResource::collection($permohonanSurveyFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan survey tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Menyusun Survey

    //Evaluasi Survey
    public function approveOrRejectSurveyEvaluation(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'status' => 'required|in:1,2',
                'catatan' => 'nullable|required_if:status,2'
            ];

            $messages = [];

            $attributes = [
                'status' => 'Status',
                'catatan' => 'Catatan'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 11);
                        $query->where('jenis', 2);
                    });
                })
                ->whereDoesntHave('permohonan_evaluasi_survey.dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })
                ->where('is_bast_fisik', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanEvaluasiSurvey = new PermohonanEvaluasiSurvey();
                    $permohonanEvaluasiSurvey->catatan = $request->catatan;
                    $permohonanEvaluasiSurvey->status = $request->status;
                    $permohonanEvaluasiSurvey->id_permohonan = $permohonan->id;
                    $permohonanEvaluasiSurvey->id_dinas = $dinas->id;
                    $permohonanEvaluasiSurvey->save();
                    
                    $dinasCount = Dinas::whereHas('user', function($query) use ($permohonan) {
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
                    })->count();

                    $permohonanEvaluasiSurveyCount = PermohonanEvaluasiSurvey::whereHas('permohonan', function($query) use ($permohonan) {
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
                    })->count();

                    if($permohonanEvaluasiSurveyCount == $dinasCount)
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

                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                        ->where('jenis_bast', 2)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
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
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data evaluasi survey berhasil disimpan';
                    $this->responseData['permohonan_evaluasi_survey'] = new PermohonanEvaluasiSurveyResource($permohonanEvaluasiSurvey);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function uploadFileSurveyEvaluation(Request $request, $id_permohonan_evaluasi_survey)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'array|min:1',
                'file.*' => 'required|file'
            ];

            $messages = [];

            $attributes = [
                'file' => 'Unggahan dokumen',
                'file.*' => 'Unggahan dokumen'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonanEvaluasiSurvey = PermohonanEvaluasiSurvey::where('id', $id_permohonan_evaluasi_survey)
                ->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })->first();

                if(!empty($permohonanEvaluasiSurvey))
                {
                    $path = 'bast_fisik/' . $permohonanEvaluasiSurvey->id_permohonan . '/evaluasi_survey/' . $permohonanEvaluasiSurvey->id;

                    if(!empty($request->file))
                    {
                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanEvaluasiSurveyFile = new PermohonanEvaluasiSurveyFile();
                            $permohonanEvaluasiSurveyFile->id_permohonan_evaluasi_survey = $permohonanEvaluasiSurvey->id;
                            $permohonanEvaluasiSurveyFile->nama = $value->getClientOriginalName();
                            $permohonanEvaluasiSurveyFile->path = $path . '/' . $changedName;
                            $permohonanEvaluasiSurveyFile->ukuran = $value->getSize();
                            $permohonanEvaluasiSurveyFile->ext = $value->getClientOriginalExtension();
                            $permohonanEvaluasiSurveyFile->is_gambar = $is_image;
                            $permohonanEvaluasiSurveyFile->save();
                        }
                    }

                    $permohonanEvaluasiSurveyFile = PermohonanEvaluasiSurveyFile::whereHas('permohonan_evaluasi_survey', function($query) use ($permohonanEvaluasiSurvey, $dinas) {
                        $query->where('id', $permohonanEvaluasiSurvey->id);
                        $query->whereHas('dinas', function($query) use ($dinas) {
                            $query->where('id', $dinas->id);
                        });
                    })->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_evaluasi_survey_file'] = PermohonanEvaluasiSurveyFileResource::collection($permohonanEvaluasiSurveyFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan evaluasi survey tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listApproveOrRejectSurveyEvaluation($id)
    {
        try
        {
            $permohonanEvaluasiSurvey = PermohonanEvaluasiSurvey::with(['dinas', 'permohonan_evaluasi_survey_file'])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            });

            $permohonanEvaluasiSurvey = $permohonanEvaluasiSurvey->orderBy('id', 'desc')->get();
            $permohonanSurveyEvaluationApproveCount = $permohonanEvaluasiSurvey->where('status', 1)->count();
            $permohonanSurveyEvaluationRejectCount = $permohonanEvaluasiSurvey->where('status', 2)->count();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan evaluasi survey berhasil ditampilkan';
            $this->responseData['approve_count'] = $permohonanSurveyEvaluationApproveCount;
            $this->responseData['reject_count'] = $permohonanSurveyEvaluationRejectCount;
            $this->responseData['permohonan_evaluasi_survey'] = PermohonanEvaluasiSurveyResource::collection($permohonanEvaluasiSurvey);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Evaluasi Survey

    //Menyusun & Revisi Konsep
    public function composeConcept($id)
    {
        DB::beginTransaction();
        try
        {
            $berkasKonsep = BerkasKonsep::where('is_bast_fisik', true)->pluck('id');

            $permohonan = Permohonan::with(['permohonan_konsep_file' => function($query) use ($berkasKonsep) {
                $query->whereHas('berkas_konsep', function($query) use ($berkasKonsep) {
                    $query->whereIn('id', $berkasKonsep);
                    $query->where('is_bast_fisik', true);
                });
                $query->where('jenis_bast', 2);
                $query->where('is_revisi', false);
            }])
            ->where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 2);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 12);
                    $query->where('jenis', 2);
                });
            })->where('is_bast_fisik', true)->first();

            if(!empty($permohonan))
            {
                $checkCompleteCount = 0;

                $groupBerkasKonsep = collect($permohonan->permohonan_konsep_file)->groupBy('id_berkas_konsep')->all();

                foreach($groupBerkasKonsep as $key => $value)
                {
                    $havePdf = false;
                    $haveDoc = false;

                    foreach($value as $key2 => $value2)
                    {
                        if($value2['ext'] == 'pdf') $havePdf = true;
                        if(in_array($value2['ext'], ['doc', 'docx'])) $haveDoc = true;
                    }

                    if($havePdf == true && $haveDoc == true) $checkCompleteCount += 1;
                }

                if(count($berkasKonsep) == $checkCompleteCount)
                {
                    $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                    ->where('jenis_bast', 2)->first();

                    if(!empty($permohonanHist))
                    {
                        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                        $permohonanHist->jumlah_hari = $jumlahHari;
                        $permohonanHist->save();

                        $permohonanHist = new PermohonanHistoriPenyelesaian();
                        $permohonanHist->id_permohonan = $permohonan->id;
                        $permohonanHist->id_proses_permohonan = 13;
                        $permohonanHist->jenis_bast = 2;
                        $permohonanHist->save();
                        
                        $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                        $permohonan->save();

                        PermohonanTimeline::storeTimeline($permohonan->id, 6, 2);

                        $this->responseCode = 200;
                        $this->responseMessage = 'Data konsep berhasil disimpan';
                        DB::commit();
                    }
                    else
                    {
                        $this->responseCode = 400;
                        $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                        DB::rollBack();
                    }
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Terdapat berkas konsep yang belum lengkap (wajib terdapat 1 file PDF dan 1 file DOC/DOCX)';
                    DB::rollBack();
                }
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan tidak ditemukan';
                DB::rollBack();
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function revisionConcept($id)
    {
        DB::beginTransaction();
        try
        {
            $berkasKonsep = BerkasKonsep::where('is_bast_fisik', true)->pluck('id');

            $permohonan = Permohonan::with(['permohonan_konsep_file' => function($query) use ($berkasKonsep) {
                $query->whereHas('berkas_konsep', function($query) use ($berkasKonsep) {
                    $query->whereIn('id', $berkasKonsep);
                    $query->where('is_bast_fisik', true);
                });
                $query->where('jenis_bast', 2);
                $query->where('is_revisi', true);
            }])
            ->where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 2);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 14);
                    $query->where('jenis', 2);
                });
            })->where('is_bast_fisik', true)->first();

            if(!empty($permohonan))
            {
                $checkCompleteCount = 0;

                $groupBerkasKonsep = collect($permohonan->permohonan_konsep_file)->groupBy('id_berkas_konsep')->all();

                foreach($groupBerkasKonsep as $key => $value)
                {
                    $havePdf = false;

                    foreach($value as $key2 => $value2)
                    {
                        if($value2['ext'] == 'pdf') $havePdf = true;
                    }

                    if($havePdf == true) $checkCompleteCount += 1;
                }

                if(count($berkasKonsep) == $checkCompleteCount)
                {
                    $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                    ->where('jenis_bast', 2)->first();

                    if(!empty($permohonanHist))
                    {
                        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                        $permohonanHist->jumlah_hari = $jumlahHari;
                        $permohonanHist->save();

                        $permohonanHist = new PermohonanHistoriPenyelesaian();
                        $permohonanHist->id_permohonan = $permohonan->id;
                        $permohonanHist->id_proses_permohonan = 15;
                        $permohonanHist->jenis_bast = 2;
                        $permohonanHist->save();
                        
                        $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                        $permohonan->save();

                        PermohonanTimeline::storeTimeline($permohonan->id, 9, 2);

                        $this->responseCode = 200;
                        $this->responseMessage = 'Data revisi konsep berhasil disimpan';
                        DB::commit();
                    }
                    else
                    {
                        $this->responseCode = 400;
                        $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                        DB::rollBack();
                    }
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Terdapat berkas konsep yang belum lengkap (wajib terdapat 1 file PDF)';
                    DB::rollBack();
                }
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan tidak ditemukan';
                DB::rollBack();
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listFileComposeOrRevisionConcept(Request $request, $id, $id_berkas_konsep)
    {
        try
        {
            $permohonanKonsepFile = PermohonanKonsepFile::whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_fisik', true);
            })
            ->where('jenis_bast', 2);

            if($request->filled('is_revisi'))
            {
                $permohonanKonsepFile = $permohonanKonsepFile->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN));
            }

            $permohonanKonsepFile = $permohonanKonsepFile->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan konsep file berhasil ditampilkan';
            $this->responseData['permohonan_konsep_file'] = PermohonanKonsepFileResource::collection($permohonanKonsepFile);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function timelineFileComposeOrRevisionConcept(Request $request, $id, $id_berkas_konsep)
    {
        try
        {
            $permohonanKonsepTimeline = PermohonanKonsepTimeline::with(['permohonan_konsep_file' => function($query) use ($request) {
                $query->withTrashed();
                $query->where('jenis_bast', 2);

                if($request->filled('is_revisi'))
                {
                    $query->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN));
                }
            }])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_fisik', true);
            })
            ->where('jenis_bast', 2);

            if($request->filled('is_revisi'))
            {
                $permohonanKonsepTimeline = $permohonanKonsepTimeline->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN));
            }

            $permohonanKonsepTimeline = $permohonanKonsepTimeline->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data timeline permohonan konsep file berhasil ditampilkan';
            $this->responseData['permohonan_konsep_timeline'] = PermohonanKonsepTimelineResource::collection($permohonanKonsepTimeline);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function uploadFileComposeOrRevisionConcept(Request $request, $id, $id_berkas_konsep)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'is_revisi' => 'required',
                'file' => 'array|min:1|max:2',
                'file.*' => 'required|file|mimes:doc,docx,pdf'
            ];

            $messages = [];

            $attributes = [
                'is_revisi' => 'Revisi',
                'file' => 'Unggahan dokumen',
                'file.*' => 'Unggahan dokumen'
            ];

            if($request->filled('is_revisi') && filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN) == true)
            {
                $rules['file'] = 'array|min:1|max:1';
                $rules['file.*'] = 'required|file|mimes:pdf';
            }

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $permohonan = Permohonan::where('id', $id)->where('is_bast_fisik', true)->first();

                if(!empty($permohonan))
                {
                    $path = 'bast_fisik/' . $permohonan->id . ((filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN) == true) ? '/revisi_konsep/' : '/konsep/') . $id_berkas_konsep;

                    if(!empty($request->file))
                    {
                        $listPermohonanKonsepFileID = [];

                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanKonsepFile = new PermohonanKonsepFile();
                            $permohonanKonsepFile->id_permohonan = $permohonan->id;
                            $permohonanKonsepFile->id_berkas_konsep = $id_berkas_konsep;
                            $permohonanKonsepFile->nama = $value->getClientOriginalName();
                            $permohonanKonsepFile->path = $path . '/' . $changedName;
                            $permohonanKonsepFile->ukuran = $value->getSize();
                            $permohonanKonsepFile->ext = $value->getClientOriginalExtension();
                            $permohonanKonsepFile->is_gambar = $is_image;
                            $permohonanKonsepFile->is_revisi = filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN);
                            $permohonanKonsepFile->jenis_bast = 2;
                            $permohonanKonsepFile->save();

                            array_push($listPermohonanKonsepFileID, $permohonanKonsepFile->id);
                        }

                        PermohonanKonsepTimeline::storeTimeline($permohonan->id, $id_berkas_konsep, filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN), $listPermohonanKonsepFileID, 1, 2);
                    }

                    $permohonanKonsepFile = PermohonanKonsepFile::whereHas('permohonan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id);
                        $query->where('is_bast_fisik', true);
                    })
                    ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                        $query->where('id', $id_berkas_konsep);
                        $query->where('is_bast_fisik', true);
                    })
                    ->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN))
                    ->where('jenis_bast', 2)
                    ->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_konsep_file'] = PermohonanKonsepFileResource::collection($permohonanKonsepFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function destroyFileComposeOrRevisionConcept($id_permohonan_konsep_file)
    {
        DB::beginTransaction();
        try
        {
            $permohonanKonsepFile = PermohonanKonsepFile::where('id', $id_permohonan_konsep_file)
            ->where('jenis_bast', 2)->first();

            if(!empty($permohonanKonsepFile))
            {
                $permohonanKonsepFile->delete();

                PermohonanKonsepTimeline::storeTimeline($permohonanKonsepFile->id_permohonan, $permohonanKonsepFile->id_berkas_konsep, $permohonanKonsepFile->is_revisi, $permohonanKonsepFile->id, 2, 2);

                $this->responseCode = 200;
                $this->responseMessage = 'File berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan konsep file tidak ditemukan';
                DB::rollBack();
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Menyusun & Revisi Konsep

    //Koreksi Konsep
    public function approveOrCorrectionConcept(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'status' => 'required|in:1,2'
            ];

            $messages = [];

            $attributes = [
                'status' => 'required|in:1,2'
            ];

            if($request->filled('status') && $request->status == 2)
            {
                $rules['checker_berkas_konsep'] = 'required|array|min:1';
                $rules['checker_berkas_konsep.*.id_berkas_konsep'] = 'required';
                $rules['checker_berkas_konsep.*.have_doc'] = 'required';

                $attributes['checker_berkas_konsep'] = 'Checker berkas konsep';
                $attributes['checker_berkas_konsep.*.id_berkas_konsep'] = 'ID berkas konsep';
                $attributes['checker_berkas_konsep.*.have_doc'] = 'Status DOC';
            }

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 13);
                        $query->where('jenis', 2);
                    });
                })
                ->whereDoesntHave('permohonan_koreksi_konsep', function($query) use ($dinas) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('is_bast_fisik', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanKoreksiKonsep = new PermohonanKoreksiKonsep();
                    $permohonanKoreksiKonsep->id_permohonan = $permohonan->id;
                    $permohonanKoreksiKonsep->id_dinas = $dinas->id;
                    $permohonanKoreksiKonsep->status = $request->status;
                    $permohonanKoreksiKonsep->jenis_bast = 2;
                    $permohonanKoreksiKonsep->save();

                    $dinasCount = Dinas::whereHas('user', function($query) use ($permohonan) {
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
                    })->count();

                    $permohonanKoreksiKonsepCount = PermohonanKoreksiKonsep::whereHas('permohonan', function($query) use ($permohonan) {
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
                    ->where('jenis_bast', 2)->count();

                    if($request->status == 2)
                    {
                        $checkCompleteCount = 0;

                        foreach($request->checker_berkas_konsep as $key => $value)
                        {
                            if($value['have_doc'] == true)
                            {
                                $checkCompleteCount += 1;
                            }
                        }

                        if(count($request->checker_berkas_konsep) != $checkCompleteCount)
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Terdapat berkas konsep yang belum lengkap (wajib terdapat 1 file DOC/DOCX)';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    if($permohonanKoreksiKonsepCount == $dinasCount)
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

                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                        ->where('jenis_bast', 2)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
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
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data koreksi konsep berhasil disimpan';
                    $this->responseData['permohonan_koreksi_konsep'] = new PermohonanKoreksiKonsepResource($permohonanKoreksiKonsep);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function correctionConcept(Request $request, $id_permohonan_koreksi_konsep)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'id_berkas_konsep' => 'required',
                'catatan' => 'required',
                'is_revisi' => 'required'
            ];

            $messages = [];

            $attributes = [
                'id_berkas_konsep' => 'Berkas konsep',
                'catatan' => 'Catatan',
                'is_revisi' => 'Revisi'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonanKoreksiKonsep = PermohonanKoreksiKonsep::where('id', $id_permohonan_koreksi_konsep)
                ->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })->where('jenis_bast', 2)->first();

                if(!empty($permohonanKoreksiKonsep))
                {
                    $permohonanKoreksiKonsepDetail = new PermohonanKoreksiKonsepDetail();
                    $permohonanKoreksiKonsepDetail->id_permohonan_koreksi_konsep = $permohonanKoreksiKonsep->id;
                    $permohonanKoreksiKonsepDetail->id_berkas_konsep = $request->id_berkas_konsep;
                    $permohonanKoreksiKonsepDetail->catatan = $request->catatan;
                    $permohonanKoreksiKonsepDetail->is_revisi = $request->is_revisi;
                    $permohonanKoreksiKonsepDetail->save();

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data permohonan koreksi konsep detail berhasil disimpan';
                    $this->responseData['permohonan_koreksi_konsep_detail'] = new PermohonanKoreksiKonsepDetailResource($permohonanKoreksiKonsepDetail);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan koreksi konsep tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function uploadFileCorrectionConcept(Request $request, $id_permohonan_koreksi_konsep_d)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'array|min:1|max:1',
                'file.*' => 'required|file|mimes:doc,docx'
            ];

            $messages = [];

            $attributes = [
                'file' => 'Unggahan dokumen',
                'file.*' => 'Unggahan dokumen'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $dinas = auth('api')->user()->dinas;

                $permohonanKoreksiKonsepDetail = PermohonanKoreksiKonsepDetail::with(['permohonan_koreksi_konsep' => function($query) use ($dinas) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }])
                ->whereHas('permohonan_koreksi_konsep', function($query) use ($dinas) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('id', $id_permohonan_koreksi_konsep_d)->first();

                if(!empty($permohonanKoreksiKonsepDetail))
                {
                    $path = 'bast_fisik/' . $permohonanKoreksiKonsepDetail->permohonan_koreksi_konsep->id_permohonan . '/koreksi/' . $permohonanKoreksiKonsepDetail->id_berkas_konsep;

                    if(!empty($request->file))
                    {
                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanKoreksiKonsepDetailFile = new PermohonanKoreksiKonsepDetailFile();
                            $permohonanKoreksiKonsepDetailFile->id_permohonan_koreksi_konsep_detail = $permohonanKoreksiKonsepDetail->id;
                            $permohonanKoreksiKonsepDetailFile->nama = $value->getClientOriginalName();
                            $permohonanKoreksiKonsepDetailFile->path = $path . '/' . $changedName;
                            $permohonanKoreksiKonsepDetailFile->ukuran = $value->getSize();
                            $permohonanKoreksiKonsepDetailFile->ext = $value->getClientOriginalExtension();
                            $permohonanKoreksiKonsepDetailFile->is_gambar = $is_image;
                            $permohonanKoreksiKonsepDetailFile->save();
                        }
                    }

                    $permohonanKoreksiKonsepDetailFile = PermohonanKoreksiKonsepDetailFile::whereHas('permohonan_koreksi_konsep_detail', function($query) use ($permohonanKoreksiKonsepDetail, $dinas) {
                        $query->where('id', $permohonanKoreksiKonsepDetail->id);
                        $query->whereHas('permohonan_koreksi_konsep', function($query) use ($dinas) {
                            $query->where('jenis_bast', 2);
                            $query->whereHas('dinas', function($query) use ($dinas) {
                                $query->where('id', $dinas->id);
                            });
                        });
                        $query->whereHas('berkas_konsep', function($query) use ($permohonanKoreksiKonsepDetail) {
                            $query->where('id', $permohonanKoreksiKonsepDetail->id_berkas_konsep);
                            $query->where('is_bast_fisik', true);
                        });
                    })
                    ->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_koreksi_konsep_detail_file'] = PermohonanKoreksiKonsepDetailFileResource::collection($permohonanKoreksiKonsepDetailFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan koreksi konsep detail tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listFileCorrectionConcept(Request $request, $id_permohonan_koreksi_konsep, $id_berkas_konsep)
    {
        try
        {
            $permohonanKoreksiKonsepDetail = PermohonanKoreksiKonsepDetail::with(['permohonan_koreksi_konsep_detail_file'])
            ->whereHas('permohonan_koreksi_konsep', function($query) use ($id_permohonan_koreksi_konsep) {
                $query->where('id', $id_permohonan_koreksi_konsep);
                $query->where('jenis_bast', 2);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_fisik', true);
            })->first();

            if(!empty($permohonanKoreksiKonsepDetail))
            {
                $this->responseCode = 200;
                $this->responseMessage = 'Data permohonan koreksi konsep detail berhasil ditampilkan';
                $this->responseData['permohonan_koreksi_konsep_detail'] = new PermohonanKoreksiKonsepDetailResource($permohonanKoreksiKonsepDetail);
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan koreksi konsep detail tidak ditemukan';
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Koreksi Konsep

    //Persetujuan Teknis
    public function approveTechnicalApproval(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'tanggal_surat' => 'required|date',
                'tgl_bast_admin' => 'nullable|date',
                'catatan' => 'nullable'
            ];

            $messages = [];

            $attributes = [
                'tanggal_surat' => 'Tanggal Surat',
                'tgl_bast_admin' => 'Tanggal BAST Admin',
                'catatan' => 'Catatan'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if($validator->fails())
            {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            }
            else
            {
                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 2);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 15);
                        $query->where('jenis', 2);
                    });
                })
                ->whereDoesntHave('permohonan_persetujuan_teknis', function($query) {
                    $query->where('jenis_bast', 2);
                })
                ->where('is_bast_fisik', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanPersetujuanTeknis = new PermohonanPersetujuanTeknis();
                    $permohonanPersetujuanTeknis->id_permohonan = $permohonan->id;
                    $permohonanPersetujuanTeknis->nomor_surat = HelperPublic::generateTechnicalApprovalMailNumber(2);
                    $permohonanPersetujuanTeknis->tanggal_surat = $request->tanggal_surat;
                    $permohonanPersetujuanTeknis->no_bast_admin = $request->no_bast_admin;
                    $permohonanPersetujuanTeknis->tgl_bast_admin = $request->tgl_bast_admin;
                    $permohonanPersetujuanTeknis->catatan = $request->catatan;
                    $permohonanPersetujuanTeknis->status = 1;
                    $permohonanPersetujuanTeknis->jenis_bast = 2;
                    $permohonanPersetujuanTeknis->save();
                    
                    PermohonanPersetujuanTeknisTimeline::storeTimeline($permohonanPersetujuanTeknis->id, 1);

                    PermohonanTimeline::storeTimeline($permohonan->id, 10, 2);

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data persetujuan teknis berhasil disimpan';
                    $this->responseData['permohonan_persetujuan_teknis'] = new PermohonanPersetujuanTeknisResource($permohonanPersetujuanTeknis);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan tidak ditemukan';
                    DB::rollBack();
                }
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    // public function uploadFileTechnicalApproval(Request $request, $id_permohonan_persetujuan_teknis)
    // {
    //     DB::beginTransaction();
    //     try
    //     {
    //         $rules = [
    //             'file' => 'array|min:1',
    //             'file.*' => 'required|file'
    //         ];

    //         $messages = [];

    //         $attributes = [
    //             'file' => 'Unggahan dokumen',
    //             'file.*' => 'Unggahan dokumen'
    //         ];

    //         $validator = Validator::make($request->all(), $rules, $messages, $attributes);

    //         if($validator->fails())
    //         {
    //             $this->responseCode = 422;
    //             $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
    //             $this->responseData['errors'] = $validator->errors();
    //             DB::rollBack();
    //         }
    //         else
    //         {
    //             $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::where('id', $id_permohonan_persetujuan_teknis)
    //             ->where('jenis_bast', 2)->first();

    //             if(!empty($permohonanPersetujuanTeknis))
    //             {
    //                 $path = 'bast_fisik/' . $permohonanPersetujuanTeknis->id_permohonan . '/persetujuan_teknis';

    //                 if(!empty($request->file))
    //                 {
    //                     foreach ($request->file as $key => $value) {
    //                         $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
    //                         $is_image = false;
    //                         if(substr($value->getClientMimeType(), 0, 5) == 'image') {
    //                             $is_image = true;
    //                         }
                        
    //                         $value->storeAs($path, $changedName);
                        
    //                         $permohonanPersetujuanTeknisFile = new PermohonanPersetujuanTeknisFile();
    //                         $permohonanPersetujuanTeknisFile->id_permohonan_persetujuan_teknis = $permohonanPersetujuanTeknis->id;
    //                         $permohonanPersetujuanTeknisFile->nama = $value->getClientOriginalName();
    //                         $permohonanPersetujuanTeknisFile->path = $path . '/' . $changedName;
    //                         $permohonanPersetujuanTeknisFile->ukuran = $value->getSize();
    //                         $permohonanPersetujuanTeknisFile->ext = $value->getClientOriginalExtension();
    //                         $permohonanPersetujuanTeknisFile->is_gambar = $is_image;
    //                         $permohonanPersetujuanTeknisFile->save();
    //                     }
    //                 }

    //                 $permohonanPersetujuanTeknisFile = PermohonanPersetujuanTeknisFile::whereHas('permohonan_persetujuan_teknis', function($query) use ($permohonanPersetujuanTeknis) {
    //                     $query->where('id', $permohonanPersetujuanTeknis->id);
    //                     $query->where('jenis_bast', 2);
    //                 })
    //                 ->get();

    //                 $this->responseCode = 200;
    //                 $this->responseMessage = 'File berhasil diupload';
    //                 $this->responseData['permohonan_persetujuan_teknis_file'] = PermohonanPersetujuanTeknisFileResource::collection($permohonanPersetujuanTeknisFile);
    //                 DB::commit();
    //             }
    //             else
    //             {
    //                 $this->responseCode = 400;
    //                 $this->responseMessage = 'Data permohonan persetujuan teknis tidak ditemukan';
    //                 DB::rollBack();
    //             }
    //         }
    //     }
    //     catch (\Exception $ex)
    //     {
    //         $this->responseCode = 500;
    //         $this->responseMessage = $ex->getMessage();
    //         DB::rollBack();
    //     }
    //     return response()->json($this->getResponse(), $this->responseCode);
    // }

    public function approveTechnicalApprovalHead(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $role = auth('api')->user()->role;

            $permohonan = Permohonan::with(['permohonan_persetujuan_teknis' => function($query) use ($role) {
                $query->where('jenis_bast', 2);
                if($role->id == 2)
                {
                    $query->where('status', 1);
                }
                elseif($role->id == 3)
                {
                    $query->where('status', 2);
                }
                elseif($role->id == 4)
                {
                    $query->where('status', 3);
                }
                elseif($role->id == 5)
                {
                    $query->where('status', 4);
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            }])
            ->where('id', $id)->whereHas('permohonan_fisik_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 2);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 15);
                    $query->where('jenis', 2);
                });
            })
            ->whereHas('permohonan_persetujuan_teknis', function($query) use ($role) {
                $query->where('jenis_bast', 2);
                if($role->id == 2)
                {
                    $query->where('status', 1);
                }
                elseif($role->id == 3)
                {
                    $query->where('status', 2);
                }
                elseif($role->id == 4)
                {
                    $query->where('status', 3);
                }
                elseif($role->id == 5)
                {
                    $query->where('status', 4);
                }
                else
                {
                    $query->whereRaw('1 = 0');
                }
            })
            ->where('is_bast_fisik', true)
            ->first();

            if(!empty($permohonan))
            {
                $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::where('id', $permohonan->permohonan_persetujuan_teknis->id)
                ->where('jenis_bast', 2)->first();
                
                if(!empty($permohonanPersetujuanTeknis))
                {
                    $permohonanPersetujuanTeknis->id_permohonan = $permohonan->id;
                    $permohonanPersetujuanTeknis->status += 1;
                    $permohonanPersetujuanTeknis->save();

                    PermohonanPersetujuanTeknisTimeline::storeTimeline($permohonanPersetujuanTeknis->id, 2);

                    if($permohonanPersetujuanTeknis->status == 5)
                    {
                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_fisik_histori_penyelesaian)
                        ->where('jenis_bast', 2)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                            $permohonanHist->jumlah_hari = $jumlahHari;
                            $permohonanHist->save();

                            $permohonanHist = new PermohonanHistoriPenyelesaian();
                            $permohonanHist->id_permohonan = $permohonan->id;
                            $permohonanHist->id_proses_permohonan = 16;
                            $permohonanHist->jenis_bast = 2;
                            $permohonanHist->save();
                                
                            $permohonan->id_permohonan_fisik_histori_penyelesaian = $permohonanHist->id;
                            $permohonan->save();

                            PermohonanTimeline::storeTimeline($permohonan->id, 11, 2);

                            DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
                            ->update(['status' => 5, 'is_penarikan_psu' => false]);
                        }
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data persetujuan teknis berhasil disimpan';
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan persetujuan teknis tidak ditemukan';
                    DB::rollBack();
                }
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan tidak ditemukan';
                DB::rollBack();
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function listFileTechnicalApproval($id)
    {
        try
        {
            // $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::with(['permohonan_persetujuan_teknis_file'])
            // ->whereHas('permohonan', function($query) use ($id) {
            //     $query->where('id', $id);
            //     $query->where('is_bast_fisik', true);
            // })
            // ->where('jenis_bast', 2)
            // ->first();

            $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_fisik', true);
            })
            ->where('jenis_bast', 2)
            ->first();

            $berkasKonsep = BerkasKonsep::with(['permohonan_konsep_file' => function($query) use ($id) {
                $query->where('is_revisi', true);
                $query->where('jenis_bast', 2);
                $query->where('ext', 'pdf');
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_fisik', true);
                });
            }])
            ->whereHas('permohonan_konsep_file', function($query) use ($id) {
                $query->where('is_revisi', true);
                $query->where('jenis_bast', 2);
                $query->where('ext', 'pdf');
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_fisik', true);
                });
            })
            ->where('is_bast_fisik', true)->get();

            if(count($berkasKonsep) == 0)
            {
                $berkasKonsep = BerkasKonsep::with(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 2);
                    $query->where('ext', 'pdf');
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    });
                }])
                ->whereHas('permohonan_konsep_file', function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 2);
                    $query->where('ext', 'pdf');
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_fisik', true);
                    });
                })
                ->where('is_bast_fisik', true)->get();
            }

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan persetujuan teknis berhasil ditampilkan';
            $this->responseData['permohonan_persetujuan_teknis'] = (!empty($permohonanPersetujuanTeknis)) ? new PermohonanPersetujuanTeknisResource($permohonanPersetujuanTeknis) : null;
            $this->responseData['berkas_konsep'] = BerkasKonsepResource::collection($berkasKonsep);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function timelineTechnicalApproval($id)
    {
        try
        {
            $permohonanPersetujuanTeknisTimeline = PermohonanPersetujuanTeknisTimeline::whereHas('permohonan_persetujuan_teknis', function($query) use ($id) {
                $query->where('jenis_bast', 2);
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_fisik', true);
                });
            })->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data timeline permohonan persetujuan teknis berhasil ditampilkan';
            $this->responseData['permohonan_persetujuan_teknis_timeline'] = PermohonanPersetujuanTeknisTimelineResource::collection($permohonanPersetujuanTeknisTimeline);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function reportTechnicalApproval($id)
    {
        try
        {
            $permohonan = Permohonan::where('is_bast_fisik', true)->where('id', $id)->first();

            if(!empty($permohonan))
            {
                $permohonanPersetujuanTeknisAdmin = PermohonanPersetujuanTeknis::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_admin', true);
                })->where('jenis_bast', 1)->first();

                $permohonanPersetujuanTeknisFisik = PermohonanPersetujuanTeknis::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_fisik', true);
                })->where('jenis_bast', 2)->first();

                $permohonanHistVerifikasi = PermohonanHistoriPenyelesaian::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_fisik', true);
                })
                ->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 9);
                    $query->where('jenis', 2);
                })
                ->where('jenis_bast', 2)->first();

                $permohonanHistEvaluasiSurvey = PermohonanHistoriPenyelesaian::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_fisik', true);
                })
                ->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 11);
                    $query->where('jenis', 2);
                })
                ->where('jenis_bast', 2)->first();

                $ttd = Ttd::first();

                $this->responseCode = 200;
                $this->responseMessage = 'Data cetakan persetujuan teknis berhasil ditampilkan';
                $this->responseData['permohonan'] = (!empty($permohonan)) ? new PermohonanResource($permohonan) : null;
                $this->responseData['permohonan_persetujuan_teknis_admin'] = (!empty($permohonanPersetujuanTeknisAdmin)) ? new PermohonanPersetujuanTeknisResource($permohonanPersetujuanTeknisAdmin) : null;
                $this->responseData['permohonan_persetujuan_teknis_fisik'] = (!empty($permohonanPersetujuanTeknisFisik)) ? new PermohonanPersetujuanTeknisResource($permohonanPersetujuanTeknisFisik) : null;
                $this->responseData['permohonan_hist_verifikasi'] = (!empty($permohonanHistVerifikasi)) ? new PermohonanHistoriPenyelesaianResource($permohonanHistVerifikasi) : null;
                $this->responseData['permohonan_hist_evaluasi_survey'] = (!empty($permohonanHistEvaluasiSurvey)) ? new PermohonanHistoriPenyelesaianResource($permohonanHistEvaluasiSurvey) : null;
                $this->responseData['ttd'] = (!empty($ttd)) ? new TtdResource($ttd) : null;
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan tidak ditemukan';
            }
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Persetujuan Teknis
}

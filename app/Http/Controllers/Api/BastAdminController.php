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
use App\Models\PermohonanBeritaAcara;
use App\Models\PermohonanBeritaAcaraFile;
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
use App\Http\Resources\PermohonanBeritaAcaraResource;
use App\Http\Resources\PermohonanBeritaAcaraFileResource;
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

class BastAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $role = $user->role;
        $dinas = $user->dinas;

        $request->merge(['custom_resource' => true, 'role' => $role, 'jenis_bast' => 1]);

        $permohonan = Permohonan::with(['kecamatan', 'kelurahan',
        'permohonan_histori_penyelesaian_last' => function($query) {
            $query->where('jenis_bast', 1);
            $query->with(['proses_permohonan' => function($query) {
                $query->where('jenis', 1);
            }]);
        }, 'permohonan_verifikasi' => function($query) use ($dinas) {
            $query->where('jenis_bast', 1);
            
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
            $query->where('jenis_bast', 1);
            
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
            $query->where('jenis_bast', 1);
        }]);

        $permohonan = $permohonan->join(DB::raw('(SELECT id_induk_awal, MAX(permohonan_ke) AS permohonan_ke FROM permohonan WHERE is_bast_admin = true AND deleted_at IS NULL GROUP BY id_induk_awal) AS permohonan_last'), function($query) {
            $query->on(DB::raw('(permohonan.id_induk_awal, permohonan.permohonan_ke)'), DB::raw('(permohonan_last.id_induk_awal, permohonan_last.permohonan_ke)'));
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
                        $query->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                            $query->where('jenis_bast', 1);
                            $query->whereHas('proses_permohonan', function($query) {
                                $query->where('id', 6);
                                $query->where('jenis', 1);
                            });
                        })
                        ->whereHas('permohonan_persetujuan_teknis', function($query) use ($role) {
                            $query->where('jenis_bast', 1);
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
                    ->orWhereHas('permohonan_histori_penyelesaian_last', function($query) {
                        $query->whereHas('proses_permohonan', function($query) {
                            $query->where('id', 7);
                            $query->where('jenis', 1);
                        });
                    });
                });
            }
        }

        $permohonan = $permohonan->where('is_bast_admin', true);
        
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

            $request->merge(['custom_resource' => true, 'role' => $role, 'jenis_bast' => 1]);

            $permohonan = Permohonan::with(['kecamatan', 'kelurahan',
            'permohonan_histori_penyelesaian_last' => function($query) {
                $query->where('jenis_bast', 1);
                $query->with(['proses_permohonan' => function($query) {
                    $query->where('jenis', 1);
                }]);
            }, 'permohonan_verifikasi' => function($query) use ($dinas) {
                $query->where('jenis_bast', 1);
                
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
                $query->where('jenis_bast', 1);
                
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
                $query->where('jenis_bast', 1);
            }])
            ->where('is_bast_admin', true)
            ->where('id', $id)->first();

            if(!empty($permohonan)) 
            {
                //Berkas persyaratan
                $berkas = Berkas::withCount(['permohonan_persyaratan_file' => function($query) use ($id) {
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    });
                }])->where('is_bast_admin', true)->orderBy('urutan', 'asc')->get();

                //Histori penyelesaian
                $totalHari = ProsesPermohonan::where('jenis', 1)->sum('batas_waktu');
                $realisasiTotalHari = PermohonanHistoriPenyelesaian::whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_admin', true);
                })->where('jenis_bast', 1)->sum('jumlah_hari');
                $totalHariKeterlambatan = $totalHari - $realisasiTotalHari;

                $permohonanHistoriPenyelesaian = PermohonanHistoriPenyelesaian::with(['proses_permohonan' => function($query) {
                    $query->where('jenis', 1);
                }])->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_admin', true);
                })
                ->where('jenis_bast', 1)->orderBy('id', 'desc')->get();

                //Original berkas konsep
                $originalBerkasKonsep = BerkasKonsep::withCount(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 1);
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    });
                }])->where('is_bast_admin', true)->get();

                $listKoreksiBerkasKonsep = [];

                $dinas = Dinas::whereHas('user.role', function($query) {
                    $query->whereIn('id', HelperPublic::roleAsApproveAndCorrectionConceptAdmin());
                })->get();

                foreach($dinas as $key => $value)
                {
                    $permohonanKoreksiKonsep = PermohonanKoreksiKonsep::whereHas('dinas', function($query) use ($value) {
                        $query->where('id', $value->id);
                    })
                    ->where('jenis_bast', 1)
                    ->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    })
                    ->first();

                    //Koreksi berkas konsep
                    $koreksiBerkasKonsep = BerkasKonsep::with(['permohonan_koreksi_konsep_detail' => function($query) use ($id, $value) {
                        $query->withCount('permohonan_koreksi_konsep_detail_file');
                        $query->whereHas('permohonan_koreksi_konsep', function($query) use ($id, $value) {
                            $query->whereHas('dinas', function($query) use ($value) {
                                $query->where('id', $value->id);
                            });
                            $query->where('jenis_bast', 1);
                            $query->whereHas('permohonan', function($query) use ($id) {
                                $query->where('id', $id);
                                $query->where('is_bast_admin', true);
                            });
                        });
                    }])->where('is_bast_admin', true)->get();

                    array_push($listKoreksiBerkasKonsep, [
                        'dinas' => new DinasResource($value),
                        'permohonan_koreksi_konsep' => (!empty($permohonanKoreksiKonsep)) ? new PermohonanKoreksiKonsepResource($permohonanKoreksiKonsep) : null,
                        'berkas_konsep' => BerkasKonsepResource::collection($koreksiBerkasKonsep)
                    ]);
                }

                //Revisi berkas konsep
                $revisiBerkasKonsep = BerkasKonsep::withCount(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', true);
                    $query->where('jenis_bast', 1);
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    });
                }])->where('is_bast_admin', true)->get();

                $this->responseCode = 200;
                $this->responseMessage = 'Data permohonan berhasil ditampilkan';
                $this->responseData['permohonan'] = new PermohonanResource($permohonan);
                $this->responseData['berkas_persyaratan'] = BerkasResource::collection($berkas);
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
                $query->where('is_bast_admin', true);
            })
            ->whereHas('berkas', function($query) use ($id_berkas) {
                $query->where('id', $id_berkas);
                $query->where('is_bast_admin', true);
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
                $query->where('is_bast_admin', true);
            })->where('jenis_bast', 1)->orderBy('id', 'desc')->get();

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

    //Approve & Reject Permohonan
    public function approveOrRejectApplication(Request $request, $id)
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

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                    $query->where('is_pengembalian', false);
                    $query->where('jenis_bast', 1);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 2);
                        $query->where('jenis', 1);
                    });
                })
                ->whereDoesntHave('permohonan_verifikasi', function($query) use ($dinas) {
                    $query->where('jenis_bast', 1);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('is_bast_admin', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanVerifikasi = new PermohonanVerifikasi();
                    $permohonanVerifikasi->catatan = $request->catatan;
                    $permohonanVerifikasi->status = $request->status;
                    $permohonanVerifikasi->id_permohonan = $permohonan->id;
                    $permohonanVerifikasi->id_dinas = $dinas->id;
                    $permohonanVerifikasi->jenis_bast = 1;
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
                    ->where('jenis_bast', 1)->count();

                    if($permohonanVerifikasiCount == $dinasCount)
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

                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_histori_penyelesaian)
                        ->where('jenis_bast', 1)->first();

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
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data permohonan berhasil direspon';
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

    public function uploadFileRejectApplication(Request $request, $id_permohonan_verifikasi)
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

                $permohonanVerifikasi = PermohonanVerifikasi::where('id', $id_permohonan_verifikasi)
                ->whereHas('dinas', function($query) use ($dinas) {
                    $query->where('id', $dinas->id);
                })
                ->where('jenis_bast', 1)->first();

                if(!empty($permohonanVerifikasi))
                {
                    $path = 'bast_admin/' . $permohonanVerifikasi->id_permohonan . '/pengembalian/' . $permohonanVerifikasi->id;

                    if(!empty($request->file))
                    {
                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanVerifikasiFile = new PermohonanVerifikasiFile();
                            $permohonanVerifikasiFile->id_permohonan_verifikasi = $permohonanVerifikasi->id;
                            $permohonanVerifikasiFile->nama = $value->getClientOriginalName();
                            $permohonanVerifikasiFile->path = $path . '/' . $changedName;
                            $permohonanVerifikasiFile->ukuran = $value->getSize();
                            $permohonanVerifikasiFile->ext = $value->getClientOriginalExtension();
                            $permohonanVerifikasiFile->is_gambar = $is_image;
                            $permohonanVerifikasiFile->save();
                        }
                    }

                    $permohonanVerifikasiFile = PermohonanVerifikasiFile::whereHas('permohonan_verifikasi', function($query) use ($permohonanVerifikasi, $dinas) {
                        $query->where('id', $permohonanVerifikasi->id);
                        $query->where('jenis_bast', 1);
                        $query->whereHas('dinas', function($query) use ($dinas) {
                            $query->where('id', $dinas->id);
                        });
                    })->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_verifikasi_file'] = PermohonanVerifikasiFileResource::collection($permohonanVerifikasiFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan verifikasi tidak ditemukan';
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

    public function listApproveOrRejectApplication($id)
    {
        try
        {
            $permohonanVerifikasi = PermohonanVerifikasi::with(['dinas', 'permohonan_verifikasi_file'])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_admin', true);
            })->where('jenis_bast', 1);

            $permohonanVerifikasi = $permohonanVerifikasi->orderBy('id', 'desc')->get();
            $permohonanVerifikasiApproveCount = $permohonanVerifikasi->where('status', 1)->count();
            $permohonanVerifikasiRejectCount = $permohonanVerifikasi->where('status', 2)->count();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan verifikasi berhasil ditampilkan';
            $this->responseData['approve_count'] = $permohonanVerifikasiApproveCount;
            $this->responseData['reject_count'] = $permohonanVerifikasiRejectCount;
            $this->responseData['permohonan_verifikasi'] = PermohonanVerifikasiResource::collection($permohonanVerifikasi);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
    //Approve & Reject Permohonan

    //Berita Acara
    public function createEventNews(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'id_permohonan_berita_acara' => 'nullable',
                'catatan' => 'nullable'
            ];

            $messages = [];

            $attributes = [
                'id_permohonan_berita_acara' => 'ID berita acara',
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
                $permohonan = Permohonan::where('id', $id)->where('is_bast_admin', true)->first();

                if(!empty($permohonan))
                {
                    $permohonanBeritaAcara = null;

                    if($request->filled('id_permohonan_berita_acara'))
                    {
                        $permohonanBeritaAcara = PermohonanBeritaAcara::find($request->id);
                    }

                    if(!empty($permohonanBeritaAcara))
                    {
                        $permohonanBeritaAcara->catatan = $request->catatan;
                        $permohonanBeritaAcara->save();
                    }
                    else
                    {
                        $permohonanBeritaAcara = new PermohonanBeritaAcara();
                        $permohonanBeritaAcara->id_permohonan = $permohonan->id;
                        $permohonanBeritaAcara->catatan = $request->catatan;
                        $permohonanBeritaAcara->save();
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data permohonan berita acara berhasil disimpan';
                    $this->responseData['permohonan_berita_acara'] = new PermohonanBeritaAcaraResource($permohonanBeritaAcara);
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

    public function uploadFileEventNews(Request $request, $id_permohonan_berita_acara)
    {
        DB::beginTransaction();
        try
        {
            $rules = [
                'file' => 'array|max:1',
                'file.*' => 'required|file|mimes:jpg,png'
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

                $permohonanBeritaAcara = PermohonanBeritaAcara::find($id_permohonan_berita_acara);

                if(!empty($permohonanBeritaAcara))
                {
                    $path = 'bast_admin/' . $permohonanBeritaAcara->id_permohonan . '/berita_acara/' . $permohonanBeritaAcara->id;

                    if(!empty($request->file))
                    {
                        foreach ($request->file as $key => $value) {
                            $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();
                    
                            $is_image = false;
                            if(substr($value->getClientMimeType(), 0, 5) == 'image') {
                                $is_image = true;
                            }
                        
                            $value->storeAs($path, $changedName);
                        
                            $permohonanBeritaAcaraFile = new PermohonanBeritaAcaraFile();
                            $permohonanBeritaAcaraFile->id_permohonan_berita_acara = $permohonanBeritaAcara->id;
                            $permohonanBeritaAcaraFile->nama = $value->getClientOriginalName();
                            $permohonanBeritaAcaraFile->path = $path . '/' . $changedName;
                            $permohonanBeritaAcaraFile->ukuran = $value->getSize();
                            $permohonanBeritaAcaraFile->ext = $value->getClientOriginalExtension();
                            $permohonanBeritaAcaraFile->is_gambar = $is_image;
                            $permohonanBeritaAcaraFile->save();
                        }
                    }

                    $permohonanBeritaAcaraFile = PermohonanBeritaAcaraFile::whereHas('permohonan_berita_acara', function($query) use ($permohonanBeritaAcara) {
                        $query->where('id', $permohonanBeritaAcara->id);
                    })->get();

                    $this->responseCode = 200;
                    $this->responseMessage = 'File berhasil diupload';
                    $this->responseData['permohonan_berita_acara_file'] = PermohonanBeritaAcaraFileResource::collection($permohonanBeritaAcaraFile);
                    DB::commit();
                }
                else
                {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data permohonan berita acara tidak ditemukan';
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

    public function destroyFileEventNews($id_permohonan_berita_acara_file)
    {
        DB::beginTransaction();
        try
        {
            $permohonanBeritaAcaraFile = PermohonanBeritaAcaraFile::find($id_permohonan_berita_acara_file);

            if(!empty($permohonanBeritaAcaraFile))
            {
                $permohonanBeritaAcaraFile->delete();

                $this->responseCode = 200;
                $this->responseMessage = 'File berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan berita acara file tidak ditemukan';
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

    public function listEventNews($id)
    {
        try
        {
            $permohonanVerifikasi = PermohonanVerifikasi::with(['dinas', 'permohonan_verifikasi_file'])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_admin', true);
            })->where('jenis_bast', 1)->orderBy('id', 'desc')->get();

            $permohonanBeritaAcara = PermohonanBeritaAcara::with(['permohonan_berita_acara_file'])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_admin', true);
            })->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data permohonan berita acara berhasil ditampilkan';
            $this->responseData['permohonan_verifikasi'] = PermohonanVerifikasiResource::collection($permohonanVerifikasi);
            $this->responseData['permohonan_berita_acara'] = PermohonanBeritaAcaraResource::collection($permohonanBeritaAcara);
        }
        catch (\Exception $ex)
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function destroyEventNews($id_permohonan_berita_acara)
    {
        DB::beginTransaction();
        try
        {
            $permohonanBeritaAcara = PermohonanBeritaAcara::find($id_permohonan_berita_acara);

            if(!empty($permohonanBeritaAcara))
            {
                $permohonanBeritaAcara->delete();

                $this->responseCode = 200;
                $this->responseMessage = 'Data permohonan berita acara berhasil dihapus';
                DB::commit();
            }
            else
            {
                $this->responseCode = 400;
                $this->responseMessage = 'Data permohonan berita acara tidak ditemukan';
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
    //Berita Acara

    //Menyusun & Revisi Konsep
    public function composeConcept($id)
    {
        DB::beginTransaction();
        try
        {
            $berkasKonsep = BerkasKonsep::where('is_bast_admin', true)->pluck('id');

            $permohonan = Permohonan::with(['permohonan_konsep_file' => function($query) use ($berkasKonsep) {
                $query->whereHas('berkas_konsep', function($query) use ($berkasKonsep) {
                    $query->whereIn('id', $berkasKonsep);
                    $query->where('is_bast_admin', true);
                });
                $query->where('jenis_bast', 1);
                $query->where('is_revisi', false);
            }])
            ->where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 1);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 3);
                    $query->where('jenis', 1);
                });
            })->where('is_bast_admin', true)->first();

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
                    $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_histori_penyelesaian)
                    ->where('jenis_bast', 1)->first();

                    if(!empty($permohonanHist))
                    {
                        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                        $permohonanHist->jumlah_hari = $jumlahHari;
                        $permohonanHist->save();

                        $permohonanHist = new PermohonanHistoriPenyelesaian();
                        $permohonanHist->id_permohonan = $permohonan->id;
                        $permohonanHist->id_proses_permohonan = 4;
                        $permohonanHist->jenis_bast = 1;
                        $permohonanHist->save();
                        
                        $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                        $permohonan->save();

                        PermohonanTimeline::storeTimeline($permohonan->id, 4, 1);

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
            $berkasKonsep = BerkasKonsep::where('is_bast_admin', true)->pluck('id');

            $permohonan = Permohonan::with(['permohonan_konsep_file' => function($query) use ($berkasKonsep) {
                $query->whereHas('berkas_konsep', function($query) use ($berkasKonsep) {
                    $query->whereIn('id', $berkasKonsep);
                    $query->where('is_bast_admin', true);
                });
                $query->where('jenis_bast', 1);
                $query->where('is_revisi', true);
            }])
            ->where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 1);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 5);
                    $query->where('jenis', 1);
                });
            })->where('is_bast_admin', true)->first();

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
                    $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_histori_penyelesaian)
                    ->where('jenis_bast', 1)->first();

                    if(!empty($permohonanHist))
                    {
                        $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                        $permohonanHist->jumlah_hari = $jumlahHari;
                        $permohonanHist->save();

                        $permohonanHist = new PermohonanHistoriPenyelesaian();
                        $permohonanHist->id_permohonan = $permohonan->id;
                        $permohonanHist->id_proses_permohonan = 6;
                        $permohonanHist->jenis_bast = 1;
                        $permohonanHist->save();
                        
                        $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                        $permohonan->save();

                        PermohonanTimeline::storeTimeline($permohonan->id, 7, 1);

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
                $query->where('is_bast_admin', true);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_admin', true);
            })
            ->where('jenis_bast', 1);

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
                $query->where('jenis_bast', 1);

                if($request->filled('is_revisi'))
                {
                    $query->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN));
                }
            }])
            ->whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_admin', true);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_admin', true);
            })
            ->where('jenis_bast', 1);

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
                $permohonan = Permohonan::where('id', $id)->where('is_bast_admin', true)->first();

                if(!empty($permohonan))
                {
                    $path = 'bast_admin/' . $permohonan->id . ((filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN) == true) ? '/revisi_konsep/' : '/konsep/') . $id_berkas_konsep;

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
                            $permohonanKonsepFile->jenis_bast = 1;
                            $permohonanKonsepFile->save();

                            array_push($listPermohonanKonsepFileID, $permohonanKonsepFile->id);
                        }

                        PermohonanKonsepTimeline::storeTimeline($permohonan->id, $id_berkas_konsep, filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN), $listPermohonanKonsepFileID, 1, 1);
                    }

                    $permohonanKonsepFile = PermohonanKonsepFile::whereHas('permohonan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id);
                        $query->where('is_bast_admin', true);
                    })
                    ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                        $query->where('id', $id_berkas_konsep);
                        $query->where('is_bast_admin', true);
                    })
                    ->where('is_revisi', filter_var($request->is_revisi, FILTER_VALIDATE_BOOLEAN))
                    ->where('jenis_bast', 1)
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
            ->where('jenis_bast', 1)->first();

            if(!empty($permohonanKonsepFile))
            {
                $permohonanKonsepFile->delete();

                PermohonanKonsepTimeline::storeTimeline($permohonanKonsepFile->id_permohonan, $permohonanKonsepFile->id_berkas_konsep, $permohonanKonsepFile->is_revisi, $permohonanKonsepFile->id, 2, 1);

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

                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 1);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 4);
                        $query->where('jenis', 1);
                    });
                })
                ->whereDoesntHave('permohonan_koreksi_konsep', function($query) use ($dinas) {
                    $query->where('jenis_bast', 1);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('is_bast_admin', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanKoreksiKonsep = new PermohonanKoreksiKonsep();
                    $permohonanKoreksiKonsep->id_permohonan = $permohonan->id;
                    $permohonanKoreksiKonsep->id_dinas = $dinas->id;
                    $permohonanKoreksiKonsep->status = $request->status;
                    $permohonanKoreksiKonsep->jenis_bast = 1;
                    $permohonanKoreksiKonsep->save();

                    $dinasCount = Dinas::whereHas('user.role', function($query) {
                        $query->whereIn('id', HelperPublic::roleAsApproveAndCorrectionConceptAdmin());
                    })->count();

                    $permohonanKoreksiKonsepCount = PermohonanKoreksiKonsep::whereHas('permohonan', function($query) use ($permohonan) {
                        $query->where('id', $permohonan->id);
                        $query->where('is_bast_admin', true);
                    })->whereHas('dinas.user.role', function($query) {
                        $query->whereIn('id', HelperPublic::roleAsApproveAndCorrectionConceptAdmin());
                    })->where('jenis_bast', 1)->count();

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
                            $query->where('is_bast_admin', true);
                        })->whereHas('dinas.user.role', function($query) {
                            $query->whereIn('id', HelperPublic::roleAsApproveAndCorrectionConceptAdmin());
                        })->where('status', 2)->where('jenis_bast', 1)->count();

                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_histori_penyelesaian)
                        ->where('jenis_bast', 1)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
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
                        else
                        {
                            $this->responseCode = 400;
                            $this->responseMessage = 'Data permohonan histori penyelesaian terakhir tidak ditemukan';
                            DB::rollBack();
                            return response()->json($this->getResponse(), $this->responseCode);
                        }
                    }

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data konsep berhasil direspon';
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
                })->where('jenis_bast', 1)->first();

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
                    $query->where('jenis_bast', 1);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                }])
                ->whereHas('permohonan_koreksi_konsep', function($query) use ($dinas) {
                    $query->where('jenis_bast', 1);
                    $query->whereHas('dinas', function($query) use ($dinas) {
                        $query->where('id', $dinas->id);
                    });
                })
                ->where('id', $id_permohonan_koreksi_konsep_d)->first();

                if(!empty($permohonanKoreksiKonsepDetail))
                {
                    $path = 'bast_admin/' . $permohonanKoreksiKonsepDetail->permohonan_koreksi_konsep->id_permohonan . '/koreksi/' . $permohonanKoreksiKonsepDetail->id_berkas_konsep;

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
                            $query->where('jenis_bast', 1);
                            $query->whereHas('dinas', function($query) use ($dinas) {
                                $query->where('id', $dinas->id);
                            });
                        });
                        $query->whereHas('berkas_konsep', function($query) use ($permohonanKoreksiKonsepDetail) {
                            $query->where('id', $permohonanKoreksiKonsepDetail->id_berkas_konsep);
                            $query->where('is_bast_admin', true);
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
                $query->where('jenis_bast', 1);
            })
            ->whereHas('berkas_konsep', function($query) use ($id_berkas_konsep) {
                $query->where('id', $id_berkas_konsep);
                $query->where('is_bast_admin', true);
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
                'catatan' => 'nullable'
            ];

            $messages = [];

            $attributes = [
                'tanggal_surat' => 'Tanggal Surat',
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
                $permohonan = Permohonan::where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                    $query->where('jenis_bast', 1);
                    $query->whereHas('proses_permohonan', function($query) {
                        $query->where('id', 6);
                        $query->where('jenis', 1);
                    });
                })
                ->whereDoesntHave('permohonan_persetujuan_teknis', function($query) {
                    $query->where('jenis_bast', 1);
                })
                ->where('is_bast_admin', true)
                ->first();

                if(!empty($permohonan))
                {
                    $permohonanPersetujuanTeknis = new PermohonanPersetujuanTeknis();
                    $permohonanPersetujuanTeknis->id_permohonan = $permohonan->id;
                    $permohonanPersetujuanTeknis->nomor_surat = HelperPublic::generateTechnicalApprovalMailNumber(1);
                    $permohonanPersetujuanTeknis->tanggal_surat = $request->tanggal_surat;
                    $permohonanPersetujuanTeknis->catatan = $request->catatan;
                    $permohonanPersetujuanTeknis->status = 1;
                    $permohonanPersetujuanTeknis->jenis_bast = 1;
                    $permohonanPersetujuanTeknis->save();
                    
                    PermohonanPersetujuanTeknisTimeline::storeTimeline($permohonanPersetujuanTeknis->id, 1);

                    PermohonanTimeline::storeTimeline($permohonan->id, 8, 1);

                    $this->responseCode = 200;
                    $this->responseMessage = 'Data persetujuan teknis berhasil direspon';
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
    //             ->where('jenis_bast', 1)->first();

    //             if(!empty($permohonanPersetujuanTeknis))
    //             {
    //                 $path = 'bast_admin/' . $permohonanPersetujuanTeknis->id_permohonan . '/persetujuan_teknis';

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
    //                     $query->where('jenis_bast', 1);
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
                $query->where('jenis_bast', 1);
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
            ->where('id', $id)->whereHas('permohonan_histori_penyelesaian_last', function($query) {
                $query->where('jenis_bast', 1);
                $query->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 6);
                    $query->where('jenis', 1);
                });
            })
            ->whereHas('permohonan_persetujuan_teknis', function($query) use ($role) {
                $query->where('jenis_bast', 1);
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
            ->where('is_bast_admin', true)
            ->first();

            if(!empty($permohonan))
            {
                $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::where('id', $permohonan->permohonan_persetujuan_teknis->id)
                ->where('jenis_bast', 1)->first();
                
                if(!empty($permohonanPersetujuanTeknis))
                {
                    $permohonanPersetujuanTeknis->id_permohonan = $permohonan->id;
                    $permohonanPersetujuanTeknis->status += 1;
                    $permohonanPersetujuanTeknis->save();

                    PermohonanPersetujuanTeknisTimeline::storeTimeline($permohonanPersetujuanTeknis->id, 2);

                    if($permohonanPersetujuanTeknis->status == 5)
                    {
                        $permohonanHist = PermohonanHistoriPenyelesaian::where('id', $permohonan->id_permohonan_histori_penyelesaian)
                        ->where('jenis_bast', 1)->first();

                        if(!empty($permohonanHist))
                        {
                            $jumlahHari = $permohonanHist->created_at->diffInDays(Carbon::now());
                            $permohonanHist->jumlah_hari = $jumlahHari;
                            $permohonanHist->save();

                            $permohonanHist = new PermohonanHistoriPenyelesaian();
                            $permohonanHist->id_permohonan = $permohonan->id;
                            $permohonanHist->id_proses_permohonan = 7;
                            $permohonanHist->jenis_bast = 1;
                            $permohonanHist->save();
                                
                            $permohonan->id_permohonan_histori_penyelesaian = $permohonanHist->id;
                            $permohonan->save();

                            PermohonanTimeline::storeTimeline($permohonan->id, 9, 1);

                            DB::table('permohonan_ssw')->where('id', $permohonan->id_ssw)
                            ->update(['status' => 2, 'is_penarikan_psu' => false]);
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
                    $this->responseMessage = 'Data persetujuan teknis berhasil direspon';
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
            //     $query->where('is_bast_admin', true);
            // })
            // ->where('jenis_bast', 1)
            // ->first();

            $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::whereHas('permohonan', function($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_bast_admin', true);
            })
            ->where('jenis_bast', 1)
            ->first();

            $berkasKonsep = BerkasKonsep::with(['permohonan_konsep_file' => function($query) use ($id) {
                $query->where('is_revisi', true);
                $query->where('jenis_bast', 1);
                $query->where('ext', 'pdf');
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_admin', true);
                });
            }])
            ->whereHas('permohonan_konsep_file', function($query) use ($id) {
                $query->where('is_revisi', true);
                $query->where('jenis_bast', 1);
                $query->where('ext', 'pdf');
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_admin', true);
                });
            })
            ->where('is_bast_admin', true)->get();

            if(count($berkasKonsep) == 0)
            {
                $berkasKonsep = BerkasKonsep::with(['permohonan_konsep_file' => function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 1);
                    $query->where('ext', 'pdf');
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    });
                }])
                ->whereHas('permohonan_konsep_file', function($query) use ($id) {
                    $query->where('is_revisi', false);
                    $query->where('jenis_bast', 1);
                    $query->where('ext', 'pdf');
                    $query->whereHas('permohonan', function($query) use ($id) {
                        $query->where('id', $id);
                        $query->where('is_bast_admin', true);
                    });
                })
                ->where('is_bast_admin', true)->get();
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
                $query->where('jenis_bast', 1);
                $query->whereHas('permohonan', function($query) use ($id) {
                    $query->where('id', $id);
                    $query->where('is_bast_admin', true);
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
            $permohonan = Permohonan::where('is_bast_admin', true)->where('id', $id)->first();

            if(!empty($permohonan))
            {
                $permohonanPersetujuanTeknis = PermohonanPersetujuanTeknis::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_admin', true);
                })->where('jenis_bast', 1)->first();

                $permohonanHistVerifikasi = PermohonanHistoriPenyelesaian::whereHas('permohonan', function($query) use ($permohonan) {
                    $query->where('id', $permohonan->id);
                    $query->where('is_bast_admin', true);
                })
                ->whereHas('proses_permohonan', function($query) {
                    $query->where('id', 2);
                    $query->where('jenis', 1);
                })
                ->where('jenis_bast', 1)->first();

                $ttd = Ttd::first();

                $this->responseCode = 200;
                $this->responseMessage = 'Data cetakan persetujuan teknis berhasil ditampilkan';
                $this->responseData['permohonan'] = (!empty($permohonan)) ? new PermohonanResource($permohonan) : null;
                $this->responseData['permohonan_persetujuan_teknis'] = (!empty($permohonanPersetujuanTeknis)) ? new PermohonanPersetujuanTeknisResource($permohonanPersetujuanTeknis) : null;
                $this->responseData['permohonan_hist_verifikasi'] = (!empty($permohonanHistVerifikasi)) ? new PermohonanHistoriPenyelesaianResource($permohonanHistVerifikasi) : null;
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

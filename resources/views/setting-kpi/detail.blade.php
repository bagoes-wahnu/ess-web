@extends('layout.main')
@section('content')
<style>
    .table .month{
        font-size:11px;
        text-align:center;
        padding:3px !important;
    }
    .table td:first-child{
        padding:1rem;
    }
    .table-skor tr th, .table-skor tr td, .table-skk tr th,.table-skk tr td{
        text-align: center;
    }
    .text-left{
        text-align: left!important;
    }
    div .pilih-jenis{
        text-align:center;
        font-size:13px;
        font-weight:bolder;
        padding: 0.7rem 0;
        color: #A2A7C3;
        cursor:pointer;
    }
    div .pilih-jenis.active{
        border-bottom:2px solid #00A1D3;
        color: #00A1D3;

    }
    .table td:first-child{
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
    /* table tr td{
        text-align:left;
    } */
    
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <input type="hidden" value="{{$id}}" id="id_time"/>
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Setting KPI : <span id="year"></span></span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan jenis parameter KPI untuk penilaian kinerja pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button id="btn-back" class="btn btn-secondary font-weight-bolder font-size-sm me-3">
                <i class="bi bi-chevron-left me-2"></i>Kembali</button>
                <button id="btn-simpan" class="btn btn-success font-weight-bolder font-size-sm d-none" onclick="simpan()">
                Simpan Semua</button>
            </div>
        </div>
        <div class="card-body pt-9">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div class="d-flex flex-column fv-row mb-2">
					<label class="fs-5 fw-bold mb-2">Divisi</label>
					<div class="d-flex">
						<div class="col-6 me-10" id="indicator-add">
							<select class="form-select" id="select-divisi" data-control="select2" data-placeholder="Pilih Divisi">
							</select>
						</div>
						<div class="col-6">
							<button class="btn btn-light-primary btn-active-light-primary" onclick="filter()">
								Tampilkan
							</button>
						</div>
					</div>
				</div>
				<div class="tab-pane fade show active menu-form-pilih">
					<div class="card">
						<div class="card-body">
							<div class="text-center px-5">
								<img src="{{asset('assets/media/illustrations/Group.png')}}" alt="" class="mw-100 h-200px h-sm-200px" />
								<p class="text-gray-400 fs-4 fw-bold py-0">
								<br />Silahkan pilih divisi terlebih dahulu</p>
							</div>
						</div>
					</div>
				</div>
                <div class="menu-form d-none" id="list-data">
                    {{--<div class="mt-20 tab-pane fade show active">
                        <div class="d-flex flex-column fv-row mb-2">
                            <label class="fs-5 fw-bold mb-2">Jenis Parameter</label>
                            <div class="d-flex">
                                <div class="col-11 me-10" id="parameter-edit">
                                    <select class="form-select" id="select-parameter-edit" data-control="select2" data-placeholder="Pilih Jenis Parameter">
                                    </select>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-icon btn-danger btn-active-light-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class="table gs-0 gy-1" id="table-setting-skor">
                            <thead>
                                <tr class="fs-5 fw-bold">
                                    <th scope="col" style="width:35%">Prespektif</th>
                                    <th scope="col" style="width:15%">Bobot (%)</th>
                                    <th scope="col" style="width:15%">Target SKK</th>
                                    <th scope="col" style="width:15%">Target IKU</th>
                                    <th scope="col" style="width:20%"></th>
                                </tr>
                            </thead>
                            <tbody id="kolom-skor">
                                <tr class="data-new" id="data-">
                                    <td>
                                        <select class="form-select" id="select-indicator-1" data-control="select2" data-placeholder="Pilih Tata Nilai">
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-success btn-active-light-primary" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="data-new" id="data-">
                                    <td>
                                        <select class="form-select" id="select-indicator-2" data-control="select2" data-placeholder="Pilih Tata Nilai">
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control score_min" placeholder="Cth: 100"/>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-danger btn-active-light-danger" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="btn-simpan" class="btn btn-primary" onclick="tambah()">Tambah Parameter</button>
                    </div>--}}
                </div>
				<div class="col-12">
                    <button type="button" id="btn-tambah" class="btn btn-primary d-none" onclick="tambahParameter()">Tambah Parameter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-skor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Keterangan Skor</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
               <table class="table table-rounded table-striped border table-skor">
                   <thead style="font-weight: bolder">
                       <tr>
                           <th>Pencapaian</th>
                           <th>Skor</th>
                           <th>Keterangan</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td>0% - 40%</td>
                           <td>0 - 4,0</td>
                           <td>Sangat Jauh Dibawah Target</td>
                       </tr>
                       <tr>
                            <td>41% - 70%</td>
                            <td>4,1 - 5,5</td>
                            <td>Jauh Dibawah Target</td>
                        </tr>
                        <tr>
                            <td>71% - 90%</td>
                            <td>71% - 90%</td>
                            <td>Mendekati Target</td>
                        </tr>
                        <tr>
                            <td>91% - 100%</td>
                            <td>91% - 100</td>
                            <td>Sangat Jauh Dibawah Target</td>
                        </tr>
                        <tr>
                            <td>> 100%</td>
                            <td>> 100%</td>
                            <td>Melebihi Target</td>
                        </tr>
                   </tbody>
               </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/extends/js/pages/setting-kpi-detail.js')}}"></script>

<script>
    $("#check-alamat").on('change', function () {
        var self = $(this);
        if (self.is(":checked")) {
           $('.alamat').removeClass('d-none')
        } else {
            $('.alamat').addClass('d-none')
        }
    });
</script>

@endsection
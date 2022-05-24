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
    table tr td{
        text-align:left;
    }
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">IKU</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan IKU Divisi pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button id="btn-simpan" class="btn btn-primary font-weight-bolder font-size-sm d-none">
                Simpan Semua</button>
            </div>
        </div>
        <div class="card-body pt-9">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div class="col-md-12 row m-0">
                    <div class="col-md-1 mt-4">Tahun</div>
                    <div class="col-md-2 p-0">
                        <input type="text" class="form-control" id="tahun" placeholder="Pilih Tahun" readonly/>
                    </div>
                    <div class="col-md-1 mt-4">Divisi</div>
                    <div class="col-md-3 p-0">
                        <select class="form-select" id="divisi" data-control="select2" data-placeholder="Pilih divisi">
                            <option>Pilih Divisi</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="btn-filter" class="btn btn-primary">
                            <span class="indicator-label">Filter</span>
                            <span class="indicator-progress">Proses...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1 p-0 text-right mt-4 div-search d-none">
                        <span>Search</span>
                    </div>
                    <div class="col-md-2 div-search d-none">
                        <input type="text" class="form-control" id="input-search" placeholder="Search"/>
                    </div>
                </div>
                <div class="col-md-12 mt-10">
                    <div class="col-md-12 row mx-0 text-center div-loader d-none">
                        <h5>Proses ... </h5>
                    </div>
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 text-center table-poin" id="table-1">
                        <thead>
                            <tr>
                                <th style="width:15%">Divisi</th>
                                <th style="width:55%">Jenis Parameter</th>
                                <th style="width:10%">Unit</th>
                                <th style="width:10%">Target Tahun</th>
                                <th style="width:10%">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
	                		<tr>
                                <td rowspan="8">Keuangan</td>
	                			<td colspan="4"><h5>FINANCE & MARKET</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center">5</td>
                                <td class="text-center py-1"><input type="text" class="form-control w-100" placeholder="Cth: 0"/></td>
                            </tr>

                            <tr>
	                			<td colspan="4"><h5>CUSTOMER</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Melakukan Pendampingan Perizinan Investor</div></td>
	                			<td class="text-center">Bulan</td>
                                <td class="text-center">5</td>
                                <td class="text-center py-1"><input type="text" class="form-control w-100" placeholder="Cth: 0"/></td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Menyelesaikan Sertifikat Baru Investor & Sertifikat Perpanjangan Investor</div></td>
	                			<td class="text-center">Bulan</td>
                                <td class="text-center">3</td>
                                <td class="text-center py-1"><input type="text" class="form-control w-100" placeholder="Cth: 0"/></td>
                            </tr>
                            <tr>
	                			<td colspan="4"><h5>EFFECTIVE PROCESS & OUTCOMES</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Mengurus perizinan KIEC (Investasi Baru)</div></td>
	                			<td class="text-center">Bulan</td>
                                <td class="text-center">4</td>
                                <td class="text-center py-1"><input type="text" class="form-control w-100" placeholder="Cth: 0"/></td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Mengurus perizinan PT. KIEC (Izin Lama/Perpanjangan)</div></td>
	                			<td class="text-center">Bulan</td>
                                <td class="text-center">1</td>
                                <td class="text-center py-1"><input type="text" class="form-control w-100" placeholder="Cth: 0"/></td>
                            </tr>
                            <tr  style="background-color:#efefef">
	                			<td colspan="3">
                                    <div class="row mx-0 py-2 px-0">
                                        <div class="col-md-3">
                                            <p class="text-muted mb-2">Keterangan</p>
                                            <span class="fw-bolder text-warning">Belum Tercapai</span>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-muted mb-2">Target Nilai</p>
                                            <span class="fw-bolder">200</span>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="text-muted mb-2">Presentase</p>
                                            <span class="fw-bolder">100%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bolder">Total Nilai</td>
                                <td class="text-center fw-bolder">0</td>
                            </tr>
	                	</tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center pt-10" id="div-empty">
                    <img src="{{asset('assets/extends/img/search-img.svg')}}"/>
                    <p class="text-muted">Belum ada data yang dapat ditampilkan<br/>Silahkan gunakan fitur filter</p>
                <div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/extends/js/pages/iku.js')}}"></script>

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
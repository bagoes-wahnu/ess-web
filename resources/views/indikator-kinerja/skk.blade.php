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
    /* table tr td{
        text-align:left;
    } */
    
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">SKK</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan SKK karyawan pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button id="btn-simpan" class="btn btn-primary font-weight-bolder font-size-sm">
                Simpan Semua</button>
            </div>
        </div>
        <div class="card-body pt-9">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div class="col-md-12 row m-0">
                    <div class="col-md-1 mt-4 text-center">Tahun</div>
                    <div class="col-md-2 p-0">
                        <input type="text" class="form-control" id="tahun" placeholder="Pilih Tahun" readonly/>
                    </div>
                    <div class="col-md-1 mt-4 text-center">Divisi</div>
                    <div class="col-md-3 p-0">
                        <select class="form-select" id="divisi" data-control="select2" data-placeholder="Pilih divisi">
                            <option>Pilih Divisi</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="btn-filter" class="btn btn-light-primary">
                            <span class="indicator-label">Tampilkan</span>
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
                    <div class="col-md-12 row mx-0">
                        <div class="col-md-6 pilih-jenis active" id="btn-type-1" onclick="changeType('1')">Sasaran Kerja dan Penilaian Hasil Kinerja</div>
                        <div class="col-md-6 pilih-jenis" id="btn-type-2" onclick="changeType('2')">Penilaian Perilaku Kerja</div>
                    </div>
                    <div class="col-md-12 row mx-0 text-center div-loader d-none">
                        <h5>Proses ... </h5>
                    </div>
                    <div class="col-md-12 row mx-0 mt-6 mb-3">
                       <div class="col-md-2 ps-0">
                            <select class="form-select" id="select-pegawai" data-control="select2" data-placeholder="Pilih pegawai">
                            </select>
                       </div>
                       <div class="col-md-2">
                            <input type="text" class="form-control" id="bulan" placeholder="Pilih Bulan" readonly/>
                       </div>
                       <div class="col-md-2">
                           <button class="btn btn-light-warning" onclick="modalSkor()">Keterangan Skor</button>
                       </div>
                       <div class="col-md-2">
                           <button class="btn btn-light-success">Export Excel</button>
                       </div>
                       <div class="col-md-2 text-right pt-4"> Search:</div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                    <table class="table table-row-bordered border table-striped table-row-gray-300 align-middle gy-4 text-center table-skk" id="table-1" style="width:100%">
                        <thead>
                            <tr style="font-weight: bolder;text-transform:uppercase;">
                                <th style="width:10%">Nama</th>
                                <th style="width:13%">Prespektif</th>
                                <th style="width:20%">Parameter</th>
                                <th style="width:7%">Unit</th>
                                <th style="width:8.33%">Target</th>
                                <th style="width:8.33%">Real</th>
                                <th style="width:8.33%">Tercapai</th>
                                <th style="width:8.33%">Bobot</th>
                                <th style="width:8.33%">Skor</th>
                                <th style="width:8.33%">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
	                		<tr>
                                <td rowspan="7">Ninda Sari</td>
	                			<td class="text-left">Finance & Market</td>
                                <td class="text-left">Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Finance & Market</td>
                                <td class="text-left">Pengendalian biaya cast flow (by konsultan, by rapat, consumable, dll)</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Customer</td>
                                <td class="text-left">Melakukan Pendampingan Perizinan Investor</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Customer</td>
                                <td class="text-left">Menyelesaikan Sertifikat Baru Investor & Sertifikat Perpanjangan Investor Dalam Negeri</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Customer</td>
                                <td class="text-left">Menyelesaikan Sertifikat Baru Investor & Sertifikat Perpanjangan Investor Asing</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Effective Process & Outcomes</td>
                                <td class="text-left">Mengurus perizinan KIEC (Investasi Baru)</td>
                                <td>Min %</td>
                                <td>100</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0%</td>
                                <td>20%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
                                <td class="text-left"><h5>Jumlah Nilai</h5></td>
                                <td colspan="2"></td>
                                <td><h5>900%</h5></td>
                                <td><h5>0%</h5></td>
                                <td><h5>0%</h5></td>
                                <td><h5>100%</h5></td>
                                <td><h5>0</h5></td>
                                <td><h5>0</h5></td>
                            </tr>

                            
	                	</tbody>
                    </table>
                    <table class="table table-row-bordered border table-striped table-row-gray-300 align-middle gy-4 text-center table-skk d-none" id="table-2" style="width:100%">
                        <thead>
                            <tr style="font-weight: bolder;text-transform:uppercase;">
                                <th style="width:10%">Nama</th>
                                <th style="width:20%">Tata Nilai</th>
                                <th style="width:25%">Aspek Perilaku</th>
                                <th style="width:15%">Bobot</th>
                                <th style="width:15%">Skor</th>
                                <th style="width:15%">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
	                		<tr>
                                <td rowspan="7">Ninda Sari</td>
	                			<td class="text-left">Integritas</td>
                                <td class="text-left">Kepatuhan kepada jam kerja</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Integritas</td>
                                <td class="text-left">Jumlah pelanggaran</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Kreatif</td>
                                <td class="text-left">Jumlah keterlibatan dalam kegiatan inovasi atau improvement</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Kreatif</td>
                                <td class="text-left">Jumlah kegiatan sharing knowledge</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Handal</td>
                                <td class="text-left">Kecepatan pelayanan</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
	                			<td class="text-left">Loyal</td>
                                <td class="text-left">Jumlah kehadiran dalam kegiatan perusahaan</td>
                                <td>15%</td>
                                <td><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td>0</td>
	                		</tr>
                            <tr>
                                <td class="text-left"><h5>Jumlah Nilai</h5></td>
                                <td></td>
                                <td><h5>100%</h5></td>
                                <td><h5>0</h5></td>
                                <td><h5>0</h5></td>
                            </tr>

                            
	                	</tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center pt-10 d-none" id="div-empty">
                    <img src="{{asset('assets/extends/img/search-img.svg')}}"/>
                    <p class="text-muted">Belum ada data yang dapat ditampilkan<br/>Silahkan gunakan fitur filter</p>
                <div>
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

<script src="{{asset('assets/extends/js/pages/skk.js')}}"></script>

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
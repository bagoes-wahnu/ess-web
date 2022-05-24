@extends('layout.main')
@section('content')
<style>
    .table input{
        font-size:11px;
        padding:3px;
        height:25px;
        width:25px;
        text-align:center;
    }
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
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Poin Karyawan - 2021</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan poin karyawan pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button id="btn-simpan"  class="btn btn-primary font-weight-bolder font-size-sm d-none">
                Simpan</button>
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
                    <div class="col-md-12 row mx-0">
                        <div class="col-md-6 pilih-jenis active" id="btn-type-1" onclick="changeType('1')">knowledge management</div>
                        <div class="col-md-6 pilih-jenis" id="btn-type-2" onclick="changeType('2')">CRM</div>
                    </div>
                    <div class="col-md-12 row mx-0 text-center div-loader d-none">
                        <h5>Proses ... </h5>
                    </div>
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 text-center d-none table-poin" id="table-1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th colspan="6" width="30%">Bulan</th>
                                <th class="d-none">BLN s/d</th>
                                <th>Perhitungan</th>
                                <th>Target</th>
                                <th>Persentase</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="generate-poin-1">
                            {{--<tr>
                                <td rowspan="4">Ninda Sari</td>
                                <td class="month">JAN</td>
                                <td class="month">FEB</td>
                                <td class="month">MAR</td>
                                <td class="month">APR</td>
                                <td class="month">MAI</td>
                                <td class="month">JUN</td>
                                <td rowspan="4">350</td>
                                <td rowspan="4">300</td>
                                <td rowspan="4">300</td>
                                <td rowspan="4">100%</td>
                                <td rowspan="4" class="text-primary font-weight-bolder">Sudah Tercapai</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                            </tr>
                            <tr>
                                <td class="month">JUL</td>
                                <td class="month">AGT</td>
                                <td class="month">SEP</td>
                                <td class="month">OKT</td>
                                <td class="month">NOV</td>
                                <td class="month">DES</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                            </tr>--}}
                        </tbody>
                    </table>
                    <table class="table table-row-dashed table-row-gray-300 align-middle gy-4 text-center d-none table-poin" id="table-2">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th colspan="6" width="30%">Bulan</th>
                                <th class="d-none">BLN s/d</th>
                                <th>Perhitungan</th>
                                <th>Target</th>
                                <th>Persentase</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="generate-poin-2">
                            {{--<tr>
                                <td rowspan="4">Ninda Sari</td>
                                <td class="month">JAN</td>
                                <td class="month">FEB</td>
                                <td class="month">MAR</td>
                                <td class="month">APR</td>
                                <td class="month">MAI</td>
                                <td class="month">JUN</td>
                                <td rowspan="4">350</td>
                                <td rowspan="4">300</td>
                                <td rowspan="4">300</td>
                                <td rowspan="4">100%</td>
                                <td rowspan="4" class="text-primary font-weight-bolder">Sudah Tercapai</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                            </tr>
                            <tr>
                                <td class="month">JUL</td>
                                <td class="month">AGT</td>
                                <td class="month">SEP</td>
                                <td class="month">OKT</td>
                                <td class="month">NOV</td>
                                <td class="month">DES</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                                <td><input type="text" class="form-control" placeholder="0"/></td>
                            </tr>--}}
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center pt-10" id="div-empty">
                    <img src="{{asset('assets/extends/img/search-img.svg')}}"/>
                    <p class="text-muted">Belum ada data yang dapat ditampilkan<br/><span class="use-filter-please">Silahkan gunakan fitur filter</span></p>
                <div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/extends/js/pages/poin-karyawan.js')}}"></script>

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
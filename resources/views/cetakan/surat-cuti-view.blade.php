
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pemeriksaan Kesehatan | KS-ESS</title>
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{asset('assets/extends/css/cetak/mainpage-A4-portrait.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .col-md-kusus-padding{-ms-flex:0 0 2.1833325%;flex:0 0 2.1833325%;max-width:2.1833325%}
    </style>
    <link rel="shortcut icon" href="{{asset('assets/mtr/dist/assets/media/logos/fav.png')}}" />
    <style>
        p{
            line-height: 1.5;
        }
        .box {
            border: 1px solid black;
            padding: 5px;
        }
        .box-color {
            background-color: #c9c9c9;
        }
        .header-this{
            height: 15mm;
        }
        .isi-this{
            height:247mm;
        }
        .mt-2 {
            margin-top: 0.5rem !important;
        }
        .mb-0, .my-0 {
            margin-bottom: 0 !important;
        }
        .mb-1, .my-1 {
            margin-bottom: 0.25rem !important;
        }
        .mb-2, .my-2 {
            margin-bottom: 0.5rem !important;
        }
        .mb-3, .my-3 {
            margin-bottom: 0.75rem !important;
        }
        .mb-4, .my-4 {
            margin-bottom: 1rem !important;
        }
        table.style-table th,table.style-table td{
            vertical-align: middle;
            font-size:11px
        }
        table td, table th {
            padding: 5px !important;
        }
        .px-1{
            padding:0 0.25rem !important;
        }
        @page {
            size: A5 landscape;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="landscape">
        <div class="book dis-none" id="xa-content">
            <!-- page 1 -->
            <div class="page">
                <div class="header header-this padding-bottom0 row m-0" style="padding:1cm 1cm 0 1cm  !important">
                    <div class="col-md-4">
                        <img src="{{asset('assets/extends/img/ks-logo.png')}}" width="80%"/>
                    </div>
                    <div class="col-md-8 text-center"></div>
                </div>

                <div class="isi" style="padding: 0cm 1cm 0.5cm!important;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="19"><h1>SURAT CUTI</h1></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3">NOMOR</td>
                                <td colspan="12"></td>
                                <td>TANGGAL</td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3">NO. REG</td>
                                <td colspan="6">NAMA KARYAWAN</td>
                                <td colspan="6">JABATAN</td>
                                <td colspan="4">DINAS</td>
                            </tr>
                            <tr>
                                <td colspan="3">123</td>
                                <td colspan="6"></td>
                                <td colspan="6"></td>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="3">JENIS CUTI*</td>
                                <td colspan="3">TMB</td>
                                <td colspan="3">PERIODE</td>
                                <td colspan="1">HAK</td>
                                <td colspan="7">WAKTU CUTI</td>
                                <td colspan="1">JUMLAH</td>
                                <td colspan="1">SISA</td>
                            </tr>
                            <tr>
                               <td>TH</td>
                               <td>BS</td>
                               <td>HM</td>
                               <td rowspan="2"></td>
                               <td rowspan="2"></td>
                               <td rowspan="2"></td>
                               <td rowspan="2"></td>
                               <td rowspan="2">/</td>
                               <td rowspan="2"></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td rowspan="2">s/d</td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td><span>hr</span></td>
                               <td><span>hr</span></td>
                            </tr>
                            <tr>
                               <td>ST</td>
                               <td>BB</td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td><span>hr</span></td>
                               <td><span>hr</span></td>
                            </tr>
                            <tr>
                                <td colspan="10" style="border-bottom:none !important">Alamat selama cuti :</td>
                                <td colspan="9" style="border-bottom:none !important">Alamat yang dapat dihubungi :</td>
                            </tr>
                            <tr>
                                <td colspan="10" style="border-bottom:none !important;height:4rem"></td>
                                <td colspan="9" style="border-bottom:none !important;height:4rem"></td>
                            </tr>
                            <tr>
                                <td colspan="10">Telp :</td>
                                <td colspan="9">Telp :</td>
                            </tr>
                            <tr>
                                <td colspan="19" style="border-bottom:none !important">Keterangan :</td>
                            </tr>
                            <tr>
                                <td colspan="19" style="border-bottom:none !important;height:4rem"></td>
                            </tr>
                            <tr>
                                <td colspan="6">PEMOHON</td>
                                <td colspan="8">DIRUT/DIREKTUR/MANAGER</td>
                                <td colspan="5">SDM & UMUM</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="border-bottom:none !important;height:4rem"></td>
                                <td colspan="8" style="border-bottom:none !important;height:4rem"></td>
                                <td colspan="5" style="border-bottom:none !important;height:4rem"></td>
                            </tr>
                            <tr>
                                <td colspan="19" style="border-bottom:none !important">*Coret yang tidak perlu ; TH: Tahunan; BS: Besar; HM: Hamil; ST:Sakit; BB: Bebas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{--<div class="footer dis-none">

                </div>--}}
            </div>
        </div>
    </div>
    <div class="div-float">
        <a href="{{url('cetak/surat-cuti/download')}}" target="_blank" class="float">
            <i class="fa fa-print my-float"></i>
        </a>
    </div>
    <div class="div-float-left">
        <a href="javascript:;" onclick="window.close();" class="float">
            <i class="fa fa-angle-left my-float boldd"></i>
        </a>
    </div>
    <script>
        var baseUrl = "{{url('/')}}/";
        var urlApi = "{{url('/api')}}/";
    </script>
    @include('layout.js')

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SPD | KS-ESS</title>
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
        body{
            font-size:12pt;
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
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="potrait">
        <div class="book dis-none" id="xa-content">
            <!-- page 1 -->
            <div class="page">
                <div class="header header-this padding-bottom0 row m-0">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 text-center">
                        <img src="{{asset('assets/extends/img/ks-logo.png')}}" width="100%"/>
                    </div>
                </div>

                <div class="isi" style="padding: 0cm 1cm 0.5cm!important;">
                    <div class="row m-0">
                        <div class="col-md-6">
                            <p>
                                Kepada Yth.<br/>
                                Divisi Human Capital<br/>
                                PT. Krakatau Industrial Estate Cilegon<br/>
                                Di, -<br/>
                                Tempat
                            </p><br/>
                            <p>Dengan Hormat</p>
                        </div>
                        <div class="col-md-12">
                            <span>Mohon Dapat Dibuatkan SPD Untuk :</span>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th width="20%"></th>
                                        <th width="80%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nama</td>
                                        <td>: Valdy R</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>: Manager SC</td>
                                    </tr>
                                    <tr>
                                        <td>Pangkat</td>
                                        <td>: -</td>
                                    </tr>
                                    <tr>
                                        <td>Unit Kerja</td>
                                        <td>: Sport Center</td>
                                    </tr>
                                    <tr>
                                        <td>Hari</td>
                                        <td>: Rabu <span>s/d</span> Kamis [...............]</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>: 22.09.2021 <span>s/d</span> 23.09.2021</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan</td>
                                        <td>: KSBM</td>
                                    </tr>
                                    <tr>
                                        <td>Keperluan Dinas</td>
                                        <td rowspan="3">: Rapat dengan P Ridi<br/> <br/> </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Kendaraan</td>
                                        <td>: Dinas / Pribadi / Umum / Pesawat / KA</td>
                                    </tr>
                                    <tr>
                                        <td>No. Kendaraan</td>
                                        <td>: </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Demikian disampaikan, atas bantuan dan kerjasamanya kami ucapkan<br/> terimakasih,</p>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-5 text-center">
                            <p>Cilegon, 21.09.2021</p>
                            <span>Yang Menugaskan</span>
                            <div style="height:80%"></div>
                            <p style="border-bottom:1px solid #aaa">Anton Firdaus</p>
                            <span>Direktur HR & Finance</span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>

                {{--<div class="footer dis-none">

                </div>--}}
            </div>
        </div>
    </div>
    <div class="div-float">
        <a href="javascript:;" class="float" onclick="window.print();">
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

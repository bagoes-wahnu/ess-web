
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pemeriksaan Kesehatan | KS-ESS</title>
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{asset('assets/extends/css/cetak/cetak-w-pdf.css')}}" rel="stylesheet" type="text/css" />
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
            size: A4 landscape;
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
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="7"><h1>SURAT PERINTAH LEMBUR</h1></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>NAMA</td>
                                <td colspan="4"></td>
                                <td>DIVISI</td>
                                <td style="width:30%"></td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align:left">Yang bertanda tangan dibawah ini memerintahkan untuk bekerja lembur kepada :</td>
                            </tr>
                            <tr style="text-align:center">
                                <td rowspan="2">REG</td>
                                <td rowspan="2">HARI /TANGGAL</td>
                                <td colspan="3">JAM LEMBUR</td>
                                <td rowspan="2">AKUMULASI JAM LEMBUR</td>
                                <td rowspan="2">URAIAN TUGAS</td>
                            </tr>
                            <tr style="text-align:center">
                                <td>DARI</td>
                                <td>SAMPAI</td>
                                <td>JUMLAH</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align:left">
                                <p>
                                KETERANGAN :<br/>
                                # Untuk lembur akumulasi, lembur > 16 jam/bulan diketahui Direktur atau General Manager yang bersangkutan<br/>
                                # Untuk lembur hari biasa dan atau akumulasi lembur < 16 jam/bulan diketahui Kepala Divisi yang bersangkutan
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="right-border:none"></td>
                                <td colspan="2" style="text-align:center">Cilegon, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                2021</td>
                            </tr>
                            <tr style="text-align:center">
                                <td colspan="5">MENGETAHUI</td>
                                <td colspan="2">YANG MEMERINTAHKAN</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="2" style="text-align:center;height:100px"></td>
                            </tr>
                            <tr style="text-align:center">
                                <td colspan="5">Manager</td>
                                <td colspan="2" >Senior Officer</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{--<div class="footer dis-none">

                </div>--}}
            </div>
        </div>
    </div>
    <script>
        var baseUrl = "{{url('/')}}/";
        var urlApi = "{{url('/api')}}/";
    </script>
    @include('layout.js')

</html>

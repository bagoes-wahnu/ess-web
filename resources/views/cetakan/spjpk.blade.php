
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
            vertical-align: top !important;
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
                    <div class="col-md-6">
                        <img src="{{asset('assets/extends/img/ks-logo.png')}}" width="80%"/>
                    </div>
                    <div class="col-md-6 text-center"></div>
                </div>

                <div class="isi" style="padding: 0cm 1cm 0.5cm!important;">
                    <!-- <div class="row m-0">
                        <div style="width:50%"> -->
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:20%"></th>
                                        <th style="width:40%"></th>
                                        <th style="width:40%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="padding:0">
                                        <td>Cilegon</td>
                                        <td>: 07/09/2021</td>
                                        <td rowspan="4" style="vertical-align: top">
                                            Kepada Yth.<br/>
                                            Pimpinan RS SILOAM<br/>
                                            Di<br/>
                                            TANGERANG KOTA<br/>
                                            Up SPESIALIS KEBID/PENY.KANDUNGAN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0">Nomor</td>
                                        <td style="padding:0">: 202104018</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0">Lampiran</td>
                                        <td style="padding:0">: </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0">Perihal</td>
                                        <td style="padding:0">: <u>Pemeliharaan Kesehatan</u></td>
                                    </tr>
                                </tbody>
                            </table>
                        <!-- </div>
                        <div style="width:50%">
                            <p>
                                Kepada Yth.<br/>
                                Pimpinan RS SILOAM<br/>
                                Di<br/>
                                TANGERANG KOTA<br/>
                                Up SPESIALIS KEBID/PENY.KANDUNGAN
                            </p><br/>
                        </div> -->
                        <div class="col-md-12">
                            <p>bersama ini diharapkan dapat dilakukan pemeriksaan dan pengobatan berikut pelayanan kesehatan lainya yang diberikan kepada:</p>
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
                                        <td>: <b>PUTRI WULAN SARI</b></td>
                                    </tr>
                                    <tr>
                                        <td>Umur</td>
                                        <td>: 19 tahun</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Perawatan</td>
                                        <td>: Rawat Jalan</td>
                                    </tr>
                                    <tr>
                                        <td>Status ( istri )</td>
                                        <td>: <b>SACHRUL PURNAMA</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tarif Rawat Inap</td>
                                        <td>: 500.000</td>
                                    </tr>
                                    <tr>
                                        <td>NPK</td>
                                        <td>: 0000201</td>
                                    </tr>
                                    <tr>
                                        <td>C Center</td>
                                        <td>: C111000</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Rumah</td>
                                        <td rowspan="3" style="vertical-align: top">: JL. PAGARASIH GG. MASTABIR RT. 05/09 NO 168/89
                                            KEL. CIBADAK KEC. ASTANA ANYAR </td>
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
                                        <td colspan="2"><b>FORM JAMINAN INI BERLAKU S/D TGL. 08 April 2021</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Diagnosa</td>
                                        <td>:</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Selanjutnya seluruh biaya pengobatan dan perawatan berikut biaya pelayanan kesehatan lainnya atas nama yang bersangkutan, dapat diajukan kepada :</p>
                            <p>PT. KRAKATAU INDUSTRIAL ESTATE CILEGON<br/>
                            WISMA KRAKATAU, JL. KH. YASIN BEJI NO.6 CILEGON BANTEN 42435</p>
                            <table style="width:100%">
                            <thead>
                                <tr><td style="width:33%"><td style="width:33%"><td style="width:33%"></td></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Dokter Periksa</td>
                                    <td class="text-center">Penanggung/Karyawan</td>
                                    <td class="text-center">PT KRAKATAU SARANA INFRASTRUKTURHUMAN CAPITAL</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="height:100px"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">ALDILLA PUTRI SUSILAWATI</td>
                                    <td class="text-center">VINA ERINA RAKHMAWATI</td>
                                </tr>
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">HC DEVP. & ADM SENIOR OFFICER</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                       
                        {{--<div class="col-md-4 text-center">
                            <p>Dokter Periksa</p>
                            <div style="height:50%"></div>
                            <p style="border-bottom:1px solid #aaa"></p>
                        </div>
                        <div class="col-md-4 text-center">
                            <p>Penanggung/Karyawan</p>
                            <div style="height:50%"></div>
                            <p>ALDILLA PUTRI SUSILAWATI</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <p class="text-center">PT KRAKATAU SARANA INFRASTRUKTURHUMAN CAPITAL</p>
                            <div style="height:25%"></div>
                            <p>VINA ERINA RAKHMAWATI</p>
                            <p>HC DEVP. & ADM SENIOR OFFICER</p>
                        </div>--}}
                    </div>
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

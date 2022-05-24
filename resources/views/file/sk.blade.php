
@extends('file.layout-preview')
@section('file')

<style>
 .dasar tr{
    line-height: 14px;
}
.page-break {
    page-break-after: always !important;
}
.col-md-kusus-padding{-ms-flex:0 0 2.1833325%;flex:0 0 2.1833325%;max-width:2.1833325%}
body {
    font-size: 11pt;
    background-color: white;
}
.dasar tbody tr td {
    vertical-align: top;
}

.page-landscape {
    width: 33cm;
    min-height: 21cm;
    padding: 1cm;
    margin: 1cm auto;
    border: 1px #D3D3D3 solid;
    border-radius: 5px;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

@font-face {
    font-family: "ArialGreek";
    src: url("css/font/ArialGreek.eot");
    src: url("font/ArialGreek.woff") format("woff"),
    /* url("font/ArialGreek.otf") format("opentype"); */
}

@import url('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700');

body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font-size: 11pt;
    font-family: 'Poppins', sans-serif;
    -webkit-print-color-adjust: exact !important;
}

* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}

.page {
    width: 21cm;
    max-height: 29.7cm;
    background: white;
}

.header {
    padding: 1cm 2cm !important;
    z-index: 999;
    /* border: 1px green solid; */
    height: 35mm;
    /* background: whitesmoke; */
}

.isi {
    padding: .5cm 2cm !important;
    z-index: 99909;
    /* border: 5px red solid; */
    height: 227mm;
    /* outline: 2cm rgb(11, 117, 2) solid; */
}

.footer {
    /* padding: .5cm !important; */
    padding: .5cm 2cm !important;
    z-index: 999;
    /* border: 1px green solid; */
    height: 35mm;
    /* background: whitesmoke; */
}


.icon-img {
    width: 2cm;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    padding: .1cm 0cm
}

.col-md-seperemepat {
    -ms-flex: 0 0 2.0833325%;
    flex: 0 0 2.0833325%;
    max-width: 2.0833325%
}

.col-md-setengah {
    -ms-flex: 0 0 4.166665%;
    flex: 0 0 4.166665%;
    max-width: 4.166665%
}

.col-md-kusus-padding {
    -ms-flex: 0 0 2.1833325%;
    flex: 0 0 2.1833325%;
    max-width: 2.1833325%
}

.col-md-1 {
    -ms-flex: 0 0 8.333333%;
    flex: 0 0 8.333333%;
    max-width: 8.333333%
}

.col-md-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%
}

.col-md-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%
}

.col-md-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%
}

.col-md-5 {
    -ms-flex: 0 0 41.555556%;
    flex: 0 0 41.555556%;
    max-width: 41.555556%
}

.col-md-6 {
    -ms-flex: 0 0 49.999998%;
    flex: 0 0 49.999998%;
    max-width: 49.999998%
}

.col-md-7 {
    -ms-flex: 0 0 58.333331%;
    flex: 0 0 58.333331%;
    max-width: 58.333331%
}

.col-md-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%
}

.col-md-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%
}

.col-md-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.33333%;
    max-width: 83.33333%
}

.col-md-11 {
    -ms-flex: 0 0 91.666663%;
    flex: 0 0 91.66663%;
    max-width: 91.66663%
}

.col-md-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%
}

.text-justify {
    text-align: justify !important;
    text-justify: inter-word !important;
}

.underline {
    text-decoration: underline;
}

.m-0 {
    margin: 0 !important;
}

/* margin top */
.margin-top2 {
    margin-top: 2mm !important;
}

.margin-top4 {
    margin-top: 4mm !important;
}

.margin-top5 {
    margin-top: 5mm !important;
}

.margin-top10 {
    margin-top: 10mm !important;
}

.margin-top15 {
    margin-top: 15mm !important;
}

.margin-top18 {
    margin-top: 18mm !important;
}

.margin-top20 {
    margin-top: 20mm !important;
}

.margin-top25 {
    margin-top: 25mm !important;
}

.margin-top30 {
    margin-top: 30mm !important;
}

/* margin bottom */
.margin-bottom2 {
    margin-bottom: 2mm !important;
}

.margin-bottom4 {
    margin-bottom: 4mm !important;
}

.margin-bottom5 {
    margin-bottom: 5mm !important;
}

.margin-bottom10 {
    margin-bottom: 10mm !important;
}

.margin-bottom15 {
    margin-bottom: 15mm !important;
}

.margin-bottom20 {
    margin-bottom: 20mm !important;
}

/* margin right */
.margin-right2 {
    margin-right: 2mm !important;
}

.margin-right4 {
    margin-right: 4mm !important;
}

.margin-right5 {
    margin-right: 5mm !important;
}

.margin-right10 {
    margin-right: 10mm !important;
}

.margin-right15 {
    margin-right: 15mm !important;
}

.margin-right25 {
    margin-right: 25mm !important;
}

.margin-right20 {
    margin-right: 20mm !important;
}

.margin-right25 {
    margin-right: 25mm !important;
}

/* padding */
.p-0 {
    padding: 0 !important;
}

.padding5 {
    padding: 5mm !important;
}

.padding10 {
    padding: 10mm !important;
}

.padding-top0 {
    padding-top: 0mm !important;
}

.padding-top5 {
    padding-top: 5mm !important;
}

.padding-top10 {
    padding-top: 10mm !important;
}

.padding-top15 {
    padding-top: 15mm !important;
}

.padding-top20 {
    padding-top: 20mm !important;
}

.padding-top25 {
    padding-top: 25mm !important;
}

.padding-bottom0 {
    padding-bottom: 0mm !important;
}

.padding-bottom5 {
    padding-bottom: 5mm !important;
}

.padding-bottom10 {
    padding-bottom: 10mm !important;
}

.padding-left0 {
    padding-left: 0mm !important;
}

.padding-left5 {
    padding-left: 5mm !important;
}

.padding-left10 {
    padding-left: 10mm !important;
}

.padding-left20 {
    padding-left: 20mm !important;
}

.padding-right5 {
    padding-right: 5mm !important;
}

.padding-right10 {
    padding-right: 10mm !important;
}

.padding-right15 {
    padding-right: 15mm !important;
}

.padding-right20 {
    padding-right: 20mm !important;
}

.padding-right25 {
    padding-right: 25mm !important;
}

.boldd {
    font-weight: bold;
}

.italic {
    font-style: italic;
}

.uppercase {
    text-transform: uppercase;
}

.divider {
    height: 0;
    margin: 0.1rem 0 1rem;
    overflow: hidden;
    border-top: 4px solid #6F6075;
}

.divider-xs {
    height: 0;
    margin: 0.1rem 0 1rem;
    overflow: hidden;
    border-top: 1px solid #6F6075;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.align-items-baseline {
    align-items: baseline;
}

.align-items-flex-start {
    align-items: flex-start;
}

.align-items-flex-end {
    align-items: flex-end;
}

.float-right {
    float: right;
}

.float-left {
    float: left;
}

.table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.table td,
.table th {
    border: 1px solid #ddd;
    padding: 8px;
}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #ddd;
}

.table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    color: #333;
    text-align: center;
}

.table tbody tr td:first-child {
    text-align: center;
}

.table-free {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.table-free td,
.table-free th {
    border: 1px solid #ddd;
    padding: 8px;
}

.table-free tbody tr td {
    width: 15px !important;
    height: 15px;
}

.column-hide {
    border: 0 !important;
}

.float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #31B4ED;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    box-shadow: 2px 2px 3px #999;
}

.my-float {
    margin-top: 22px;
    font-size: 18px !important;
}

.text-center {
    text-align: center !important
}

.text-left {
    text-align: left !important
}

.text-right {
    text-align: right !important
}

.coret {
    text-decoration: line-through !important;
}
</style>


<div class="page" style="">
    <div style="padding: 0px 40px 10px 45px;background-color: white; margin-top: 50px;">
        <table width="100%">
            <tr>
                <td width="100%" style="text-align: center;">
                    <div >
                        <h3 class="p-0 m-0 uppercase boldd" style="margin: 0 0 .1cm 0 !important">Pemerintah Provinsi Jawa Timur</h3>
                        <h1 class="p-0 m-0 uppercase" style="margin: 0 0 .1cm 0 !important; font-weight: 400;">Dinas kesehatan</h1>
                        <p class="p-0 m-0 uppercase boldd" style="margin: 0 0 .1cm 0 !important;">Penetapan angka kredit jabatan fungsional apoteker</p>
                        <p class="p-0 m-0  " style="margin: 0 0 .1cm 0 !important;">Nomor : KP. 102.1/PAK/</p>

                    </div>
                </td>
            </tr>
        </table>
    </div>


    <div style="padding: 0px 40px 10px 45px;background-color: white;">

        <table width="100%" style="margin-top: 20px; ">
            <tr>
                <td>
                    <soan class="" style="line-height: .4cm; font-size: 13px;">Masa Penilaian : 2 Mei 2019 s/d 30 September 2020  </span>
                    </td>
                </tr>
            </table>

            <table class="dasar" width="100%" border="1" cellpadding="5" style="border-collapse: collapse; font-size: 14px !important ;">
                <tr>
                    <td class="text-center uppercase boldd" width="5%">I</td>
                    <td class="text-center uppercase boldd" width="" colspan="4">keterangan perorangan</td>
                </tr>

                <tr>
                    <td class="text-center" width="5%" rowspan="11" ></td>
                    <td  width="45%"><span style="margin-right: 6px;" >1. </span> Nama</td>
                    <td  width="50%" colspan="3"> NAZTASIA FLOWERIN BUNDA, S.Farm., Apt  </td>
                </tr>

                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >2. </span> NIP</td>
                    <td  width="50%" colspan="3"> 19910428 201903 2 014  </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >3. </span> No. Kepreg</td>
                    <td  width="50%" colspan="3">  </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >4. </span> Tempat / Tanggal Lahir </td>
                    <td  width="50%" colspan="3"> Surabaya, 28 April 1991  </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >5. </span> Jenis Kelamin</td>
                    <td  width="50%" colspan="3">  Wanita </td>
                </tr>
                <tr>
                    <td  width="45%"> 
                        <table>
                            <tr>
                                <td>6. </td>
                                <td> Pendidikan yang telah diperhitungkan angka kreditnya </td>
                            </tr>    
                        </table> 
                    </td>
                    <td  width="50%" colspan="3"> Profesi Apoteker   </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >7. </span> Pangkat / Gol. Ruang / TMT</td>
                    <td  width="50%" colspan="3"> Penata Muda Tk. I (III/b) <span style="float: right;" > 01-03-2019 </span> </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >8. </span> Jabatan Fungsional / TMT</td>
                    <td  width="50%" colspan="3"> - <span style="float: right;" > - </span> </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >9. </span> Masa Kerja Golongan : <span style="float: right; padding-right: 24px;" >Lama</span></td>
                    <td  width="50%" colspan="3"> 00 Tahun 00 Bulan  </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" > </span>  <span style="float: right; padding-right: 29px;" >Baru</span></td>
                    <td  width="50%" colspan="3">  01 Tahun 07 Bulan </td>
                </tr>
                <tr>
                    <td  width="45%"><span style="margin-right: 6px;" >10. </span> Unit Kerja </td>
                    <td  width="50%" colspan="3">  RSUD Dr. Soetomo Surabaya </td>
                </tr>


                <tr>
                    <td class="text-center uppercase boldd" width="5%" rowspan="13">II</td>
                    <td class="text-center uppercase boldd" width="" >Penetapan angka kredit</td>
                    <td class="text-center uppercase boldd" >Lama </td>
                    <td class="text-center uppercase boldd" >Baru </td>
                    <td class="text-center uppercase boldd" >Jumlah </td>
                </tr>

                {{-- start foreach 1 --}}
                <tr>
                    <td class="" > 
                        <table class="dasar" >
                            <tr>
                                <td  class="uppercase boldd"><span style="margin-right: 8px;">1. </span>UNSUR UTAMA</td>
                            </tr>
                        </table>
                    </td>
                    <td class="" > <span style="float: right;" > - </span> </td>
                    <td class="" > <span style="float: right;" > - </span> </td>
                    <td class="" > <span style="float: right;" > - </span> </td>
                </tr>

                {{-- start foreach 2 --}}
                <tr>
                    <td class="" > 
                       <table class="dasar">
                        <tr>
                            <td ><span style="margin-right: 8px; margin-left: 20px;">a. </span>Pendidikan</td>
                        </tr>
                    </table>
                </td>
                <td class="" > <span style="float: right;" > - </span> </td>
                <td class="" > <span style="float: right;" > - </span> </td>
                <td class="" > <span style="float: right;" > - </span> </td>
            </tr>

            {{-- start foreach 3--}}
            <tr>
                <td class="" > 
                    <table class="dasar">
                        <tr>
                            <td style="padding-left: 40px;">
                                <table>
                                    <tr>
                                        <td width="12%"><span >1.)</span> </td>
                                        <td> Pendidikan Formal</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="" > <span style="float: right;" > - </span> </td>
                <td class="" > <span style="float: right;" > - </span> </td>
                <td class="" > <span style="float: right;" > - </span> </td>
            </tr>
            <tr>
                <td class="" > 
                   <table class="dasar">
                    <tr>
                        <td style="padding-left: 40px;">
                            <table>
                                <tr>
                                    <td width="12%"><span >2.)</span> </td>
                                    <td> Pendidikan dan pelatihan fungsional di bidang kefarmasian dan mendapat STTPP</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="" > <span style="float: right;" > - </span> </td>
            <td class="" ><span style="float: right;" > - </span>  </td>
            <td class="" > <span style="float: right;" > - </span> </td>
        </tr>
        <tr>
            <td class="" > 
               <table class="dasar">
                <tr>
                    <td style="padding-left: 40px;">
                        <table>
                            <tr>
                                <td width="12%"><span >3.)</span> </td>
                                <td> Pendidikan dan pelatihan Jabatan</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="" > <span style="float: right;" > - </span> </td>
        <td class="" > <span style="float: right;" > - </span> </td>
        <td class="" > <span style="float: right;" > - </span> </td>
    </tr>
    {{-- end foreach 3--}}

    <tr>
        <td class="" > 
           <table class="dasar">
            <tr>
                <td ><span style="margin-right: 8px; margin-left: 20px;">b. </span>Pekerjaan Kefarmasian</td>
            </tr>
        </table>
    </td>
    <td class="" > <span style="float: right;" > - </span> </td>
    <td class="" > <span style="float: right;" > - </span> </td>
    <td class="" > <span style="float: right;" > - </span> </td>
</tr>
<tr>
    <td class="" > 
       <table class="dasar">
        <tr>
            <td ><span style="margin-right: 8px; margin-left: 20px;">c. </span>Pengembangan Profesi</td>
        </tr>
    </table>
</td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
</tr>
{{-- end foreach 2 --}}

<tr>
    <td class="" > 
       <table class="dasar">
        <tr>
            <td class="uppercase boldd" style="padding-left: 20px;">Jumlah Unsur Utama</td>
        </tr>
    </table>
</td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
</tr>
{{-- end foreach 1 --}}


<tr>
    <td class="" > 
        <table class="dasar">
            <tr>
                <td  class="uppercase boldd"><span style="margin-right: 8px;">2. </span>UNSUR PENUNJANG</td>
            </tr>
        </table>
    </td>
    <td class="" > <span style="float: right;" > - </span> </td>
    <td class="" > <span style="float: right;" > - </span> </td>
    <td class="" > <span style="float: right;" > - </span> </td>
</tr>

<tr>
    <td class="" > 
       <table class="dasar">
        <tr>
            <td ><span style="margin-right: 8px; margin-left: 20px;">a. </span>Penunjang tugas Apoteker</td>
        </tr>
    </table>
</td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
</tr>
<tr>
    <td class="" > 
       <table class="dasar">
        <tr>
            <td class="uppercase boldd" style="padding-left: 20px;">Jumlah Unsur Penunjang</td>
        </tr>
    </table>
</td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" > <span style="float: right;" > - </span> </td>
</tr>

<tr>
    <td class="" > 
       <table class="dasar">
        <tr>
            <td class="uppercase boldd" >Jumlah Unsur utama dan unsur Penunjang</td>
        </tr>
    </table>
</td>
<td class="" ><span style="float: right;" > - </span>  </td>
<td class="" > <span style="float: right;" > - </span> </td>
<td class="" ><span style="float: right;" > - </span> </td>
</tr>

<tr>
    <td class="text-center uppercase boldd" width="5%" rowspan="13">III</td>
    <td class="" width="" colspan="4">
        PAK untuk pengangkatan pertama dalam jabatan fungsional / pangkat : <br>
        <b>Apoteker Ahli Pertama, Penata Muda Tk. I (III/b)</b>
    </td>
</tr>

</table>


<table>
    <tr>
        <td>
            <div  ><br><br><br><br><br><br><br><br>
               Asli disampaikan : <br>
               Yth. Kepala Kantor Regional II BKN 
               <br>
               <p style="padding-left: 6px;">
                Tembusan : <br>
                1. Kepala BKD Provinsi Jawa Timur; <br>
                2. Direktur RSUD Dr. Soetomo Surabaya; <br>
                3. Sdr. NAZTASIA FLOWERIN BUNDA, S.Farm., Apt. <br>
            </p>
        </div>
    </td>

    <td align="right">
       <table width="100%">
        <tr>
            <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="70%" >
                <div style="">
                    <p class="p-0 m-0" style="margin: 0 0 .1cm 0 !important; text-align: left;">Ditetapkan di Surabaya</p>
                    <p class="p-0 m-0" style="margin: 0 0 .1cm 0 !important; text-align: left;">Pada tanggal : <p>
                        <p class="p-0 m-0 uppercase" style="margin: 0 0 .1cm 0 !important; text-align: center;"> 
                         <span> KEPALA DINAS kesehatan</span><br> 
                         <span> provinsi jawa timur</span>
                     </p>
                 </div>
                 <div style="text-align: center !important;">
                    <p class="p-0 margin-top15 underline boldd" style="margin-bottom: 0.1cm !important; text-align: center;">dr. HERLIN FERLIANA, M.Kes </b> </p>
                    <span class="p-0 m-0" style="margin: 0 0 .1cm 0 !important; ">Pembina Utama Muda</span><br>
                    <span class="p-0 m-0" style="margin: 0 0 .1cm 0 !important; ">NIP. 19640621 199011 2 001  </span>
                </div>
            </td>
        </tr>
    </table>    
    </td>
</tr>
</table>

</div>
</div>

@endsection

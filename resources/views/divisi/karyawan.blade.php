@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px"> Tambah Karyawan Divisi</span></br>
                <span class="text-muted" style="font-size:16px">Silahan centang karyawan lalu klik tambahkan untuk menambahkan karyawan ke divisi ini.</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" id="btn-tambah-karyawan" class="btn btn-primary d-none" onclick="addKaryawan()">
                    <span class="indicator-label">Tambahkan</span>
                    <span class="indicator-progress">Proses menyimpan...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
        <input type="hidden" id="id_divisi" value="{{$id_divisi}}">
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">

                <div id="table-wrapper-karyawan">
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
                                <th scope="col">
                                    <label class="checkbox">
                                        <input type="checkbox"  id="check-all" >
                                    <span></span></label>
                                </th>
                                <th scope="col">No</th>
	                			<th scope="col">NIP</th>
	                			<th scope="col">Username</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jabatan</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
                                <td class="text-center">
                                    <label class="checkbox">
                                        <input type="checkbox" name="Checkboxes1" class="check">
                                    <span></span></label>
                                </td>
                                <td class="text-center"> 1  </td>
                                <td class="text-center">2103147011</td>
                                <td  class="text-center"> dinivan_nendra</td>
                                <td> Dinivan Nendra Gunawan</td>
                                <td>  UX Designer/Engineer </td>
	                		</tr>

                           <tr>
                                <td class="text-center">
                                    <label class="checkbox">
                                        <input type="checkbox" name="Checkboxes1" class="check">
                                    <span></span></label>
                                </td>
                                <td class="text-center"> 1  </td>
                                <td class="text-center">2103147011</td>
                                <td  class="text-center"> dinivan_nendra</td>
                                <td> Dinivan Nendra Gunawan</td>
                                <td>  UX Designer/Engineer </td>
                            </tr>
	                		
	                	</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px"> Karyawan Divisi: <span class="nama-divisi"></span> </span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan data karyawan pada divisi <span class="nama-divisi"></span> aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">

                <div id="table-wrapper-karyawan-divisi">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="font-weight-bolder text-center" style="text-transform: uppercase;">
                                <th scope="col">No</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Username</th>
                                <th scope="col">Nama karyawan</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody-karyawan-divisi">
                            <tr>
                                <td class="text-center"> 1  </td>
                                <td class="text-center">2103147011</td>
                                <td  class="text-center"> dinivan_nendra</td>
                                <td> Dinivan Nendra Gunawan</td>
                                <td>  UX Designer/Engineer </td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="removeKaryawan()">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                        <path d="M11.3333 14.0007C11.3333 13.6325 11.6317 13.334 11.9999 13.334H19.9999C20.3681 13.334 20.6666 13.6325 20.6666 14.0007V20.0007C20.6666 21.1053 19.7712 22.0007 18.6666 22.0007H13.3333C12.2287 22.0007 11.3333 21.1053 11.3333 20.0007V14.0007Z" fill="#F1416C"/>
                                        <path opacity="0.5" d="M11.3333 11.3327C11.3333 10.9645 11.6317 10.666 11.9999 10.666H19.9999C20.3681 10.666 20.6666 10.9645 20.6666 11.3327C20.6666 11.7009 20.3681 11.9993 19.9999 11.9993H11.9999C11.6317 11.9993 11.3333 11.7009 11.3333 11.3327Z" fill="#F1416C"/>
                                        <path opacity="0.5" d="M14 10.6667C14 10.2985 14.2985 10 14.6667 10H17.3333C17.7015 10 18 10.2985 18 10.6667H14Z" fill="#F1416C"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="{{asset('assets/extends/js/pages/divisi-karyawan.js')}}"></script>






@endsection
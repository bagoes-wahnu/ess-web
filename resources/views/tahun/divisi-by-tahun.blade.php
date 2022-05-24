@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Tahun Divisi - <span>2021</span></span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan tahun divisi pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{url('tahun')}}" id="btn-simpan" class="btn btn-warning"><i class="bi bi-chevron-left me-0"></i>Kembali</a>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">

            	{{-- <div class="row" style="position: absolute;z-index: 9;right: 22vw;"> 
		            <div class=" col-md-4 form-group" >
		                <input type="text" class="form-control" name="" id="filter-bulan" placeholder="semua bulan" readonly="">
		            </div>
		        </div> --}}

                <div id="table-wrapper">
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col">No</th>
	                			<th scope="col">Divisi</th>
	                			<th scope="col" style="width:50%">Alamat</th>
                                <th scope="col">Anggota</th>
	                			<th scope="col">Action</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td class="text-center">1</td>
	                			<td>Design</td>
	                			<td class="text-center">Jl. Kertajaya No.160, Kertajaya, Kec. Gubeng, Kota SBY, Jawa Timur</td>
                                <td class="text-center">12</td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M16.0322024,5.68722152 L5.75790403,15.945742 C5.12139076,16.5812778 5.12059836,17.6124773 5.75613416,18.2489906 C5.75642891,18.2492858 5.75672377,18.2495809 5.75701875,18.2498759 L5.75701875,18.2498759 C6.39304347,18.8859006 7.42424328,18.8859006 8.060268,18.2498759 C8.06056298,18.2495809 8.06085784,18.2492858 8.0611526,18.2489906 L18.3196731,7.9746922 C18.9505124,7.34288268 18.9501191,6.31942463 18.3187946,5.68810005 L18.3187946,5.68810005 C17.68747,5.05677547 16.6640119,5.05638225 16.0322024,5.68722152 Z" fill="#50CD89" fill-rule="nonzero"/>
                                                <path d="M9.85714286,6.92857143 C9.85714286,8.54730513 8.5469533,9.85714286 6.93006028,9.85714286 C5.31316726,9.85714286 4,8.54730513 4,6.92857143 C4,5.30983773 5.31316726,4 6.93006028,4 C8.5469533,4 9.85714286,5.30983773 9.85714286,6.92857143 Z M20,17.0714286 C20,18.6901623 18.6898104,20 17.0729174,20 C15.4560244,20 14.1428571,18.6901623 14.1428571,17.0714286 C14.1428571,15.4497247 15.4560244,14.1428571 17.0729174,14.1428571 C18.6898104,14.1428571 20,15.4497247 20,17.0714286 Z" fill="#50CD89" opacity="0.3"/>
                                            </g>
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

<div class="modal fade" tabindex="-1" id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tahun</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form id="form-input">
                <div class="modal-body">
                    <input type="hidden" id="id" >
                    <div class="form-group  mb-4">
                        <label for="nama" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="tahun" readonly="readonly" placeholder="Pilih Tahun" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan()">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Proses menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 



<script src="{{asset('assets/extends/js/pages/tahun.js')}}"></script>






@endsection
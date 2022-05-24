@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Parameter Nilai</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan parameter nilai pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" id="btn-kembali" class="btn btn-light-warning btn-sm me-3 d-none" onclick="closeEditor()"><i class="bi bi-chevron-left me-2"></i>Kembali</button>
                <button type="button" id="btn-simpan" class="btn btn-success btn-sm me-3 d-none" onclick="serializeData()">Simpan Semua</button>
                <button type="button" id="btn-add" class="btn btn-light-primary btn-sm me-3" onclick="tambah()"><i class="bi bi-plus-lg me-2"></i>Jenis Parameter</button>
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
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="table-jenis-parameter">
                		{{--<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col" style="width:70%">Jenis Parameter</th>
	                			<th scope="col">Unit</th>
	                			<th scope="col">Aksi</th>
	                		</tr>
                		</thead>
                		<tbody id="jenis-1">
	                		<tr>
	                			<td colspan="2"><h5>FINANCE & MARKET</h5></td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-sm btn-success btn-active-light-primary" onclick="openEditor('create','1')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <i class="bi bi-plus-lg"></i>
	                				</button>
                                </td>
	                		</tr>
                            <tr id="data-2">
                                <td><div class="ps-6">
                                    <span class="data-label">Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)</span>
                                    <input type="text" class="form-control data-input d-none" placeholder="Cth: Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)"
                                    value="Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)"/>
                                </div></td>
	                			<td class="text-center"><span class="data-label">Min %</span><input type="text" class="form-control data-input d-none" placeholder="Cth: Min %" value="Min %"/></td>
	                			<td class="text-center">
                                    <button class="btn btn-icon data-label" onclick="openEditor('edit','1','2')">
                                        <span class="svg-icon svg-icon-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </button>
                                    <button class="btn btn-icon btn-sm btn-danger btn-active-light-danger data-input d-none" onclick="removeEditor('2')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>--}}
                        <!-- per jenis 1 tbody -->
                	</table>
                </div>
                <div class="col-md-12 text-center py-10 d-none" id="div-empty">
                    <img src="{{asset('assets/extends/img/search-img.svg')}}"/>
                    <p class="text-muted">Belum ada data yang dapat ditampilkan<br/>Silahkan tambahkan parameter nilai terlebih dahulu</p>
                    <button type="button" class="btn btn-light-primary me-3" onclick="tambah()"><i class="bi bi-plus-lg me-2"></i>Jenis Parameter</button>
                <div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Parameter Nilai</h5>

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
                        <label for="nama" class="form-label">Nama Jenis</label>
                        <select class="form-select" data-control="select2" id="select_parameter_type">
                        </select>
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



<script src="{{asset('assets/extends/js/pages/parameter-nilai.js')}}"></script>






@endsection
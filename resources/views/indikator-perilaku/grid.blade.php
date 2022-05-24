@extends('layout.main')
@section('content')

<div class="container">
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px"> Indikator Perilaku Penilaian</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan indikator perilaku penilaian pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="tambah()">Tambah</button>
                {{-- <button type="button" id="btn-simpan" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">Tambah</button> --}}
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <div class="kt-portlet__body">
                <div id="table-wrapper">
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col">No</th>
	                			<th scope="col">Tata Nilai</th>
	                			<th scope="col">Aspek Perilaku</th>
                                <th scope="col">Status</th>
	                			<th scope="col">Action</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td class="text-center">1</td>
	                			<td class="text-center"> Integritas</td>
                                <td class="text-center">    Kepatuhan terhadap jam kerja</td>
                                <td class="text-center"> 
                                    <div style="padding: 0 3rem;">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            {{-- <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/> --}}
                                            <input class="form-check-input" type="checkbox" checked="checked" value=""/>
                                            <label class="form-check-label" for="chk-switch"></label>
                                        </div>
                                    </div>
                                </td>
	                			<td class="text-center">
	                				{{-- <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="edit()"> --}}
                                    <button class="btn btn-icon btn-color-primary btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
	                				<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                    <path d="M21.6691 14.9489L15.2959 21.6868C15.107 21.8865 14.8443 21.9997 14.5694 21.9997L11.6667 21.9997C11.1144 21.9997 10.6667 21.5519 10.6667 20.9997L10.6667 18.0713C10.6667 17.8116 10.7677 17.562 10.9485 17.3755L17.3878 10.7293C17.7721 10.3326 18.4052 10.3226 18.8019 10.7069C18.8057 10.7106 18.8094 10.7143 18.8131 10.718L21.6497 13.5546C22.0326 13.9375 22.0412 14.5555 21.6691 14.9489Z" fill="#FCAD00"/>
                                    </svg>
	                				</button>
	                			</td>
	                		</tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center"> Integritas</td>
                                <td class="text-center"> Jumlah pelanggaran</td>
                                <td class="text-center"> 
                                    <div style="padding: 0 3rem;">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            {{-- <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/> --}}
                                            <input class="form-check-input" type="checkbox" checked="checked" value=""/>
                                            <label class="form-check-label" for="chk-switch"></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{-- <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="edit()"> --}}
                                    <button class="btn btn-icon btn-color-primary btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                        <path d="M21.6691 14.9489L15.2959 21.6868C15.107 21.8865 14.8443 21.9997 14.5694 21.9997L11.6667 21.9997C11.1144 21.9997 10.6667 21.5519 10.6667 20.9997L10.6667 18.0713C10.6667 17.8116 10.7677 17.562 10.9485 17.3755L17.3878 10.7293C17.7721 10.3326 18.4052 10.3226 18.8019 10.7069C18.8057 10.7106 18.8094 10.7143 18.8131 10.718L21.6497 13.5546C22.0326 13.9375 22.0412 14.5555 21.6691 14.9489Z" fill="#FCAD00"/>
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

<div class="modal fade" id="modal-add" data-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <form class="form" id="kt_modal_new_form">
                <div class="modal-header" id="kt_modal_new_header">
                    <h2 class="modal-title"></h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-0">
                    <input type="hidden" id="id" >
                    <div class="card card-xxl-stretch mb-0 mb-xl-0">
                        <div class="card-header border-0 pt-0">
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <div class="row" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                        <div class="col-6 w-375px" id="add-menu">
                                        </div>
                                        <div class="col-6 w-375px">
                                            <label id="label-aspect" class="mt-2 btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 me-2" data-bs-toggle="tab" href="#kt_widget_tab_2" data-kt-button="true">
                                                <span class="form-check form-check-custom form-check-sm align-items-middle mt-1">
                                                    <input class="form-check-input menu-2" type="radio" name="type" value="2" onclick="aspek()"/>
                                                </span>
                                                <span class="ms-5 mt-2">
                                                    <span class="fs-4 fw-bolder text-gray-800 mb-2 d-block">Aspek Perilaku</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div class="tab-content">
                                <div class="tab-pane fade show active menu-form-pilih">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center px-5">
                                                <img src="{{asset('assets/media/illustrations/Group.png')}}" alt="" class="mw-100 h-100px h-sm-100px" />
                                                <p class="text-gray-400 fs-4 fw-bold py-0">Belum ada data yang dapat ditampilkan
                                                <br />Silahkan pilih menu diatas untuk membuat data indikator penilaian</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade menu-form" id="kt_widget_tab_1">
                                    <div class="col-md-12 fv-row">
                                        <label class="fs-5 fw-bold mt-5 mb-2">Nama</label>
                                        <input id="nama-indikator" type="text" class="form-control mb-5" name="row-name" placeholder="Cth: Integritas"/>
                                    </div>
                                </div>
                                <div class="tab-pane fade menu-form" id="kt_widget_tab_2">
                                    <div class="d-flex flex-column fv-row">
                                        <label class="fs-5 fw-bold mb-2">Tata Nilai</label>
                                        {{-- <select class="form-select select-perspektif" data-control="select2" data-dropdown-parent="#modal-add" id="select-perspektif-sasaran" name="param" style="width:100%">
                                        </select> --}}
                                        <div class="d-none" id="indicator-edit">
                                            <select class="form-select " id="select-indicator-edit" data-control="select2" data-placeholder="Pilih Indikator" onchange="changeName()">
                                            </select>
                                        </div>
                                        <div id="indicator-add">
                                            <select class="form-select" id="select-indicator" data-control="select2" data-placeholder="Pilih Indikator">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-12 fv-row">
                                            <label class="fs-5 fw-bold mt-5 mb-2">Aspek Perilaku</label>
                                            <input type="text" class="form-control" placeholder="Cth: Kepatuhan terhadap jam kerja" id="nama-aspek" name="nama-aspek" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-right btn-aspect" id="change-button">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('assets/extends/js/pages/indikator-perilaku.js')}}"></script>
@endsection
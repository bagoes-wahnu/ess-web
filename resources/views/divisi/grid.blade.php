@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px"> Divisi</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan divisi pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="tambah()">Tambah</button>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">

                <div id="table-wrapper">
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col">No</th>
	                			<th scope="col">Nama Divisi</th>
	                			<th scope="col">Lokasi</th>
                                <th scope="col">Anggota</th>
                                <th scope="col">Status</th>
	                			<th scope="col">Action</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td class="text-center">1</td>
	                			<td class="text-center"> Keuangan</td>
                                <td class="text-center">    Jl. Kertajaya No.160, Kertajaya, Kec. Gubeng, Kota SBY, Jawa Timur</td>
                                <td class="text-center"> 12</td>
                                <td class="text-center"> 
                                    <div style="padding: 0 3rem;">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/>
                                            <label class="form-check-label" for="chk-switch"></label>
                                        </div>
                                    </div>
                                </td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="karyawan()">
	                					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                        <path opacity="0.3" d="M22.6666 16.0007C22.6666 19.6673 19.6666 22.6673 16 22.6673C12.3333 22.6673 9.33331 19.6673 9.33331 16.0007C9.33331 12.334 12.3333 9.33398 16 9.33398C19.6666 9.33398 22.6666 12.334 22.6666 16.0007ZM16 12.6673C14.8666 12.6673 14 13.534 14 14.6673C14 15.8007 14.8666 16.6673 16 16.6673C17.1333 16.6673 18 15.8007 18 14.6673C18 13.534 17.1333 12.6673 16 12.6673Z" fill="#50CD89"/>
                                        <path d="M16 22.6667C17.7333 22.6667 19.3333 22 20.4667 20.9333C19.9333 19.2667 18.1333 18 16 18C13.8667 18 12.0667 19.2667 11.5333 20.9333C12.6667 22 14.2667 22.6667 16 22.6667Z" fill="#50CD89"/>
                                        </svg>

	                				</button>

	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="edit()">
	                				<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                    <path d="M21.6691 14.9489L15.2959 21.6868C15.107 21.8865 14.8443 21.9997 14.5694 21.9997L11.6667 21.9997C11.1144 21.9997 10.6667 21.5519 10.6667 20.9997L10.6667 18.0713C10.6667 17.8116 10.7677 17.562 10.9485 17.3755L17.3878 10.7293C17.7721 10.3326 18.4052 10.3226 18.8019 10.7069C18.8057 10.7106 18.8094 10.7143 18.8131 10.718L21.6497 13.5546C22.0326 13.9375 22.0412 14.5555 21.6691 14.9489Z" fill="#FCAD00"/>
                                    </svg>
	                				</button>
	                			</td>
	                		</tr>

                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center"> Software Engineer</td>
                                <td class="text-center"> Jl. Kertajaya No.160, Kertajaya, Kec. Gubeng, Kota SBY, Jawa Timur</td>
                                <td class="text-center"> 12</td>
                                <td class="text-center"> 
                                    <div style="padding: 0 3rem;">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/>
                                            <label class="form-check-label" for="chk-switch"></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="karyawan()">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 5C0 2.23858 2.23858 0 5 0H27C29.7614 0 32 2.23858 32 5V27C32 29.7614 29.7614 32 27 32H5C2.23858 32 0 29.7614 0 27V5Z" fill="white"/>
                                        <path opacity="0.3" d="M22.6666 16.0007C22.6666 19.6673 19.6666 22.6673 16 22.6673C12.3333 22.6673 9.33331 19.6673 9.33331 16.0007C9.33331 12.334 12.3333 9.33398 16 9.33398C19.6666 9.33398 22.6666 12.334 22.6666 16.0007ZM16 12.6673C14.8666 12.6673 14 13.534 14 14.6673C14 15.8007 14.8666 16.6673 16 16.6673C17.1333 16.6673 18 15.8007 18 14.6673C18 13.534 17.1333 12.6673 16 12.6673Z" fill="#50CD89"/>
                                        <path d="M16 22.6667C17.7333 22.6667 19.3333 22 20.4667 20.9333C19.9333 19.2667 18.1333 18 16 18C13.8667 18 12.0667 19.2667 11.5333 20.9333C12.6667 22 14.2667 22.6667 16 22.6667Z" fill="#50CD89"/>
                                        </svg>
                                    </button>

                                    <button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="edit()">
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

{{--<button class="btn btn-icon btn-color-warning "  onclick="edit(`+data+`)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
    <i class="bi bi-pencil-fill"></i>
</button>--}}

<div class="modal fade"  id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Instansi</h5>

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
                        <label for="nama" class="form-label">Nama Divisi</label>
                        <input type="text" class="form-control" id="nama-divisi" placeholder="Masukkan nama divisi"/>
                    </div>
                    <div class="form-group  mb-4">
                        <label for="lokasi-kantor" class="form-label">Lokasi Kantor</label>
                        <select class="form-select " id="lokasi-kantor" data-control="select2" data-placeholder="Pilih lokasi kantor">
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



<script src="{{asset('assets/extends/js/pages/divisi.js')}}"></script>






@endsection
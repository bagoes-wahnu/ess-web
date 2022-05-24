@extends('layout.main')
@section('content')

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Data Master Hari Libur</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan data Hari Libur dari aplikasi PSU</span>
            </h3>
            <div class="card-toolbar">
                <button  class="btn btn-warning font-weight-bolder font-size-sm" onclick="create()">
                <i class="fas fa-plus"></i>
                Tambah Data</button>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div id="table-wrapper">
                    <!-- <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">Nama Hari</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Tahun Baru Masehi 2021</td>
                                <td>01 Januari 2020</td>
                                <td>
                                    <label class="form-check form-switch form-check-custom form-check-solid form-check-primary">
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked">
                                    </label>
                                </td>
                                <td>
                                <a href="javascript:;" onclick="edit()" class="" title="Edit">
                                   <i class="la la-pen" style="font-size:1.5rem"></i>
                                </a>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Berkas</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-input">
                    <div class="form-group  mt-2">
                        <label for="nama" class="form-label">Nama Hari</label>
                        <input type="hidden" id="id">
                        <input type="text" class="form-control " id="nama-hari" placeholder="Cth: Tahun baru masehi"/>
                    </div>
                    <div class="row">
                    <div class="col-md-6 my-4">
                        <label class="form-label">Tanggal Awal</label>
                        <div class="input-group date">
                            <input id="tanggal-awal" type="text" class="form-control" readonly="readonly" placeholder="Pilih tanggal" readonly/>
                            <div class="input-group-append bg-secondary">
                                <span class="input-group-text">
                                    <svg width="15" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.499878 18.625C0.499878 19.6602 1.36372 20.5 2.42845 20.5H16.5713C17.636 20.5 18.4999 19.6602 18.4999 18.625V8H0.499878V18.625ZM3.07131 11.125C3.07131 10.7812 3.36059 10.5 3.71416 10.5H7.57131C7.92488 10.5 8.21416 10.7812 8.21416 11.125V14.875C8.21416 15.2188 7.92488 15.5 7.57131 15.5H3.71416C3.36059 15.5 3.07131 15.2188 3.07131 14.875V11.125ZM16.5713 3H14.6427V1.125C14.6427 0.78125 14.3534 0.5 13.9999 0.5H12.7142C12.3606 0.5 12.0713 0.78125 12.0713 1.125V3H6.92845V1.125C6.92845 0.78125 6.63916 0.5 6.28559 0.5H4.99988C4.64631 0.5 4.35702 0.78125 4.35702 1.125V3H2.42845C1.36372 3 0.499878 3.83984 0.499878 4.875V6.75H18.4999V4.875C18.4999 3.83984 17.636 3 16.5713 3Z" fill="#B5B5C3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 my-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <div class="input-group date">
                            <input id="tanggal-akhir" type="text" class="form-control" readonly="readonly" placeholder="Pilih tanggal" readonly/>
                            <div class="input-group-append bg-secondary">
                                <span class="input-group-text">
                                    <svg width="15" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.499878 18.625C0.499878 19.6602 1.36372 20.5 2.42845 20.5H16.5713C17.636 20.5 18.4999 19.6602 18.4999 18.625V8H0.499878V18.625ZM3.07131 11.125C3.07131 10.7812 3.36059 10.5 3.71416 10.5H7.57131C7.92488 10.5 8.21416 10.7812 8.21416 11.125V14.875C8.21416 15.2188 7.92488 15.5 7.57131 15.5H3.71416C3.36059 15.5 3.07131 15.2188 3.07131 14.875V11.125ZM16.5713 3H14.6427V1.125C14.6427 0.78125 14.3534 0.5 13.9999 0.5H12.7142C12.3606 0.5 12.0713 0.78125 12.0713 1.125V3H6.92845V1.125C6.92845 0.78125 6.63916 0.5 6.28559 0.5H4.99988C4.64631 0.5 4.35702 0.78125 4.35702 1.125V3H2.42845C1.36372 3 0.499878 3.83984 0.499878 4.875V6.75H18.4999V4.875C18.4999 3.83984 17.636 3 16.5713 3Z" fill="#B5B5C3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-warning" onclick="simpan()">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
            </div>
            </form>
        </div>
    </div>
</div> 
<script src="{{asset('assets/extends/js/master/hari-libur.js')}}"></script>

@endsection
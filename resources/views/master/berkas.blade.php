@extends('layout.main')
@section('content')

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Data Master Berkas</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan data Berkas dari aplikasi PSU</span>
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
                                <th scope="col">Nama Berkas</th>
                                <th scope="col">Urutan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>BAST Fisik</td>
                                <td>1</td>
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
                    <div class="form-group  mt-5">
                        <label for="nama" class="form-label">Nama Berkas</label>
                        <input type="hidden" id="id" value="">
                        <input type="text" class="form-control " id="nama-berkas" placeholder="Cth: BAST Fisik"/>
                    </div>

                    <div class="form-group  mt-5">
                        <label for="nama" class="form-label">Urutan</label>
                        <input type="text" class="form-control " id="urutan" placeholder="Cth: 1"/>
                    </div>

                    {{-- <div class="form-group  mt-5">
                         <label for="tipe" class="form-label d-block">Tipe Berkas</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input berkas_type" type="radio" name="inlineRadioOptions" id="bast_admin" value="1">
                          <label class="form-check-label" for="bast_admin"> Bast admin</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input berkas_type" type="radio" name="inlineRadioOptions" id="bast_fisik" value="2">
                          <label class="form-check-label" for="bast_fisik">Bast fisik</label>
                        </div>
                    </div> --}}

                    <div class="form-group  mt-5">
                       <label for="tipe" class="form-label d-block">Tipe Berkas</label>
                       <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="bast_admin" value="">
                          <label class="form-check-label" for="bast_admin">Bast admin</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="bast_fisik" value="">
                          <label class="form-check-label" for="bast_fisik">Bast fisik</label>
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
<script src="{{asset('assets/extends/js/master/berkas.js')}}"></script>

@endsection
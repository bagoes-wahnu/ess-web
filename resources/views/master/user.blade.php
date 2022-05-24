@extends('layout.main')
@section('content')

<style>
    .badge-admin {
        background-color:rgba(54, 153, 255, 1) ; color: white;
    }

    .badge-kasie {
        background-color: rgba(124, 131, 253, 1); color: white;
    }

    .badge-kabid {
        background-color: rgba(149, 56, 158, 1) ; color: white;
    }
    .badge-sekretaris {
        background-color: rgba(255, 68, 159, 1) ; color: white;
    }
    .badge-kadis {
        background-color: rgba(7, 121, 228, 1) ; color: white;
    }
    .badge-rayon {
        background-color: rgba(27, 197, 189, 1) ; color: white;
    }

    .badge-hukum {
        background-color: rgba(246, 78, 96, 1) ; color: white;
    }
    .badge-dpbt {
        background-color: rgba(137, 80, 252, 1) ; color: white;
    }
    .badge-bpn {
        background-color: rgba(0, 86, 145, 1) ; color: white;
    }
    .badge-kecamatan {
        background-color: rgba(228, 230, 239, 1) ; color: white;
    }
    .badge-kelurahan {
        background-color: rgba(12, 236, 221, 1) ; color: white;
    }
    .badge-dpubmp {
        background-color: rgb(236, 12, 222, 1) ; color: white;
    }
    .badge-dkrth {
        background-color: rgb(152, 132, 68, 1) ; color: white;
    }


</style>
<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Data Master User</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan data User dari aplikasi PSU</span>
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
                   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data User</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-input">
                    <input type="hidden" id="id" >
                    <div class="form-group">
                        <label for="select-role" class="form-label">Hak Akses</label>
                        <select class="form-select list_role"  id="select-role" name=""  style="width:100%">
                            {{-- <option>Pilih Hak Akses</option>
                            <option value="1">Administrator</option>
                            <option value="2">Rayon</option>
                            <option value="3">CKTR</option>
                            <option value="4">Hukum/DPBT</option>
                            <option value="5">Verifikator</option>
                            <option value="6">BPN</option>
                            <option value="7">Kecamatan</option>
                            <option value="8">Kelurahan</option> --}}
                        </select>
                    </div>
                    <div class="form-group mt-8 user-field dinas-field d-none">
                        <label for="select-dinas" class="form-label">Dinas</label>
                        <select class="form-select list_dinas" id="select-dinas"  name=""  style="width:100%"  aria-label="Select example">
                        </select>
                    </div>

                    <div class="form-group mt-5 user-field kecamatan-field d-none">
                        <label for="select-kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-select list_kecamatan" id="select-kecamatan"  name=""  style="width:100%"> 
                        </select>
                    </div>

                    <div class="form-group mt-5 user-field d-none" id="list-kecamatan-field">
                        <label for="select-list-kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-select list_kecamatan" id="select-list-kecamatan"  name="list_kecamatan[]" multiple="multiple" style="width:100%">
                        </select>
                    </div>

                    <div class="form-group mt-5 user-field kelurahan-field d-none">
                        <label for="select-kelurahan" class="form-label">Kelurahan</label>
                        <select class="form-select list_kelurahan " id="select-kelurahan"  name=""  style="width:100%" >
                        </select>
                    </div>

                    <div class="form-group mt-5 user-field d-none" id="list-kelurahan-field">
                        <label for="select-list-kelurahan" class="form-label">Kelurahan</label>
                        <select class="form-select list_kelurahan" id="select-list-kelurahan"  name="" multiple="multiple" style="width:100%" >
                        </select>
                    </div>

                    <div class="form-group  mt-5 user-field account-field d-none">
                        <label for="nama" class="form-label">Nama User</label>
                        <input type="text" class="form-control " id="nama-user" placeholder="Cth: Rahmad Efendi"  autocomplete="off"/>
                    </div>
                    <div class="form-group  mt-5 user-field account-field d-none">
                        <label for="nama" class="form-label">Username</label>
                        <input type="text" class="form-control " id="username" placeholder="Cth: efendi"  autocomplete="off"/>
                    </div>
                    <div class="form-group  mt-5 user-field account-field d-none">
                        <label for="nama" class="form-label"  id="label-pass">Sandi</label>
                        <input type="password" class="form-control " id="sandi" placeholder="Sandi" autocomplete="off" />
                    </div>
                    <div class="form-group  mt-5 user-field account-field d-none">
                        <label for="nama" class="form-label" id="label-confirm-pass">Konfirmasi Sandi</label>
                        <input type="password" class="form-control " id="konfirmasi-sandi" placeholder="Konfirmasi Sandi"  autocomplete="off"/>
                    </div>
                    <div class="form-group  mt-5 user-field email-field d-none">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control " id="email" placeholder="Cth: salman@gmail.com"  autocomplete="off"/>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-warning" onclick="checkPass()">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
            </div>
            </form>
        </div>
    </div>
</div> 
<script src="{{asset('assets/extends/js/master/user.js')}}"></script>

@endsection
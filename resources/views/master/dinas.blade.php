@extends('layout.main')
@section('content')

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Data Master Dinas</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan data Dinas dari aplikasi PSU</span>
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
                <h5 class="modal-title">Tambah Data Dinas</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="form-input">
                    <input type="hidden" id="id">
                    <div class="form-group  mt-4">
                        <label for="nama" class="form-label">Nama Dinas</label>
                        <input type="text" class="form-control " id="nama-dinas" placeholder="Cth: DPBT"/>
                    </div>
                    <div class="form-group  mt-4">
                        <label for="nama" class="form-label">Telepon</label>
                        <input type="text" class="form-control " id="telepon" placeholder="Cth: 031 5312144"/>
                    </div>
                    <div class="form-group  mt-4">
                        <label for="nama" class="form-label">Alamat</label>
                        <textarea  class="form-control" id="alamat" placeholder="Cth: Jalan Baratajaya"  rows="4"></textarea>
                    </div>

                    {{-- <div class="form-group  mt-6">
                        <div class="form-check form-check-custom form-check-solid form-check-primary">
                            <input class="form-check-input" type="checkbox" value="" id="check-alamat" />
                            <label class="form-check-label" for="check-alamat">
                                Perlu kecamatan dan kelurahan
                            </label>
                        </div>
                    </div>
                
                    <div class="form-group  mt-6 d-none alamat">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-control" name="kecamatan" id="kecamatan">
                             <option value="" >Lakarsantri</option>
                             <option value="" >Lakarsantri</option>
                        </select>
                    </div>
                    <div class="form-group  mt-6 d-none alamat">
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <select class="form-control" name="kelurahan" id="kelurahan">
                             <option value="" >Lakarsantri</option>
                             <option value="" >Lakarsantri</option>
                        </select>
                    </div> --}}
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
<script src="{{asset('assets/extends/js/master/dinas.js')}}"></script>

<script>
    $("#check-alamat").on('change', function () {
        var self = $(this);
        if (self.is(":checked")) {
           $('.alamat').removeClass('d-none')
        } else {
            $('.alamat').addClass('d-none')
        }
    });
</script>

@endsection
@extends('layout.main')
@section('content')

<style>
    .pointer{
        cursor: pointer;
    }
    div.active{
        background: rgba(0, 161, 211, 0.12);
    }
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Lokasi Kantor</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan lokasi kantor dari aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button id="btn-create" class="btn btn-primary font-weight-bolder font-size-sm mr-2 d-none" onclick="create()">
               {{-- <i class="fas fa-plus"></i> --}}
                Tambah Lokasi</button>

                <button  class="btn btn-outline-primary font-weight-bolder font-size-sm d-none mr-2" style="border: solid 2px #009ef7" id="btn-batal" onclick="createBatal()">Batal</button>
                <button  class="btn btn-primary font-weight-bolder font-size-sm d-none mr-2" id="btn-simpan" onclick="simpanNama()">Simpan</button>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            {{--<p class="text-primary d-none" id="text-polygon" style="font-style: italic;">Silahkan pilih titik polygon</p> --}}
            <!--begin::Alert-->
            <div class="alert alert-primary row mx-0 d-none" id="text-polygon">
                <div class="d-flex pt-3">
                    <!--begin::Title-->
                    <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black"></path>
                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black"></path>
                        </svg>
                    </span>
                    <span>Silahkan menggambar area pada map untuk memilih lokasi.</span>
                </div>
            </div>
            <div class="alert alert-primary row mx-0 d-none" id="text-radius">
                <div class="d-flex pt-3">
                    <!--begin::Title-->
                    <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black"></path>
                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black"></path>
                        </svg>
                    </span>
                    <span>Silahkan kilk pada map untuk memilih lokasi.</span>
                </div>
            </div>
            <!--end::Alert-->
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <input type="hidden" id="lat-inp"/>
                <input type="hidden" id="lng-inp"/>
                <input type="text" class="d-none" id="koordinat"/>
                <input
                id="pac-input"
                class="controls form-control"
                type="text"
                placeholder="Search Box"
                />
                <div id="Maplokasi" style="width:100%;min-height:500px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-jenis-marker">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Jenis Lokasi</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="row mb-6">
                    <div class="col-md-6">
                        <div class="col-md-12 border text-center py-6 px-3 pointer" id="btn-pointer-1" style="border-radius:5px" onclick="pointerPeta('1')">
                            <h5 class="font-weight-bolder">Radius</h5>  
                            <p class="text-muted" style="font-size:10px">Titik satu lokasi kantor pada peta</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12 border text-center py-6 px-3 pointer" id="btn-pointer-2" style="border-radius:5px" onclick="pointerPeta('2')">
                            <h5 class="font-weight-bolder">Polygon</h5>  
                            <p class="text-muted" style="font-size:10px">Titik satu koordinat ke kordinat lain untuk membentuk polygon</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4" id="div-nama">
                    <label>Masukkan nama kantor</label>
                    <input type="text" class="form-control" id="txt-name" placeholder="Nama Kantor"/>
                </div>
                <div class="col-md-12 div-radius d-none">
                    <label>Radius</label>
                    {{--<input type="number" class="form-control" id="txt-radius" placeholder="Cth: 50"/>--}}
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt-radius" placeholder="Cth: 50" aria-describedby="basic-addon2"/>
                        <div class="input-group-append"><span class="input-group-text">Meter</span></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="id-map"/>

            <div class="modal-footer row mx-0" style="justify-content: space-between;">
                <div class="col-4 p-0">
                    <button  class="btn btn-danger font-weight-bolder font-size-sm mr-2" id="btn-hapus" onclick="hapusLokasi()">Hapus Lokasi</button>
                </div>
                <div class="col-7 text-right p-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="batalEdit()">Batal</button>
                    <button  class="btn btn-primary font-weight-bolder font-size-sm mr-2" id="btn-simpan" onclick="createSimpan()">Pilih Lokasi</button>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" tabindex="-1" id="modal-nama-marker">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nama</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <label>Masukkan nama kantor</label>
                    <input type="text" class="form-control" id="txt-name" placeholder="Nama Kantor"/>
                </div>
                <div class="col-md-12 div-radius d-none">
                    <label>Radius</label>
                    <input type="number" class="form-control" id="txt-radius" placeholder="Cth: 50"/>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanNama()">Simpan</button>
            </div>
        </div>
    </div>
</div> 

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/markerclustererplus/2.1.4/markerclusterer.min.js" type="text/javascript"></script>--}}
<script src="//maps.google.com/maps/api/js?key=AIzaSyBDHDV2ksjKZ8xtSOZEOBe4_DQM87VrXgI&libraries=places&libraries=drawing&callback=renderMap" async defer></script>
<script src="{{asset('assets/extends/js/pages/lokasi-kantor.js')}}"></script>

@endsection
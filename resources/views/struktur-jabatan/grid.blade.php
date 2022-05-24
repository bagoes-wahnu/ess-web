@extends('layout.main')
@section('content')
<style>
    .w-autos{
        width:100%;
        right: 5vw;
        position: absolute;
        bottom: 1vh;
    }
    .img-profile{
        width:100%;
        border-radius:50%;
    }
    .comment-perview p{
        margin-bottom:1px;
        font-size:11px;
    }
    .accordion,.accordion-body,.accordion-collapse,.accordion-item {
        border:none
    }
    .accordion-header{
        border: 1px solid #eff2f5;
    }
</style>
<link href="{{asset('assets/extends/plugins/summernote-0.8/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark" style="font-size:20px">Struktur Jabatan</span></br>
                <span class="text-muted" style="font-size:16px">Berikut ini merupakan struktur jabatan dari aplikasi KSI - ESS</span>
            </h3>
            {{--<div class="card-toolbar">
                <button  class="btn btn-warning font-weight-bolder font-size-sm" onclick="create()">
                <i class="fas fa-plus"></i>
                Tambah Data</button>
            </div>--}}
        </div>
        <div class="card-body pt-9">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div class="accordion" id="kt_accordion_1">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-comment">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Staff Teknologi Terkait Jobdesk</h5>

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
                <div class="col-md-12 row mx-0 mb-8">
                    <div class="col-md-2">
                        <img src="{{asset('assets/img/profile.png')}}" class="img-profile"/>
                    </div>
                    <div class="col-md-10 row m-0 p-0 comment-perview">
                        <p class="col-md-6 font-weight-bolder">Aan Pambudi</p>
                        <p class="col-md-6 text-muted text-right">12 September 2021</p>
                        <p class="col-md-12 text-muted">Software Engineer - Frontend</p>
                        <p class="col-md-12" style="text-align:justify">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, debitis repellat eos perspiciatis dolorem commodi?
                            <a href="javascript:;" class="text-primary">Lihat Selengkapnya</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 row mx-0 mb-8">
                    <div class="col-md-2">
                        <img src="{{asset('assets/img/profile.png')}}" class="img-profile"/>
                    </div>
                    <div class="col-md-10 row m-0 p-0 comment-perview">
                        <p class="col-md-6 font-weight-bolder">Aan Pambudi</p>
                        <p class="col-md-6 text-muted text-right">12 September 2021</p>
                        <p class="col-md-12 text-muted">Software Engineer - Frontend</p>
                        <p class="col-md-12" style="text-align:justify">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, debitis repellat eos perspiciatis dolorem commodi?
                            <a href="javascript:;" class="text-primary">Lihat Selengkapnya</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 row mx-0 mb-8">
                    <div class="col-md-2">
                        <img src="{{asset('assets/img/profile.png')}}" class="img-profile"/>
                    </div>
                    <div class="col-md-10 row m-0 p-0 comment-perview">
                        <p class="col-md-6 font-weight-bolder">Aan Pambudi</p>
                        <p class="col-md-6 text-muted text-right">12 September 2021</p>
                        <p class="col-md-12 text-muted">Software Engineer - Frontend</p>
                        <p class="col-md-12" style="text-align:justify">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, debitis repellat eos perspiciatis dolorem commodi?
                            <a href="javascript:;" class="text-primary">Lihat Selengkapnya</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 row mx-0 mb-8">
                    <div class="col-md-2">
                        <img src="{{asset('assets/img/profile.png')}}" class="img-profile"/>
                    </div>
                    <div class="col-md-10 row m-0 p-0 comment-perview">
                        <p class="col-md-6 font-weight-bolder">Aan Pambudi</p>
                        <p class="col-md-6 text-muted text-right">12 September 2021</p>
                        <p class="col-md-12 text-muted">Software Engineer - Frontend</p>
                        <p class="col-md-12" style="text-align:justify">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, debitis repellat eos perspiciatis dolorem commodi?
                            <a href="javascript:;" class="text-primary">Lihat Selengkapnya</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-jobdesk">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>

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
            <input type="hidden" id="id" value=""/>
            <div class="modal-body pt-0">
                <div class="form-group row mt-2">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="col-form-label col-lg-3 col-sm-12">Tujuan Jabatan</label>
                        <textarea class="form-control" id="tujuan-jabatan" rows="8"></textarea>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="col-form-label col-lg-3 col-sm-12">Tanggung Jawab</label>
                        <div id="tanggung-jawab" class="summernote"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/extends/plugins/summernote-0.8/summernote.min.js')}}"></script>
<script src="{{asset('assets/extends/js/pages/struktur-organisasi.js')}}"></script>

<script>
    let imgBlank="{{asset('assets/media/avatars/blank.png')}}"

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
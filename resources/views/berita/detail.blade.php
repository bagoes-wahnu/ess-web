@extends('layout.main')
@section('content')
<style>
  .image-detail{
    width: 100%;
    min-height: 350px;
    max-height: 600px;
    background-repeat: no-repeat;
    background-size: cover;
    margin-bottom: 2rem;
  }
  .text-justify{
        text-align: justify;
    }
    .ribbon-kanan{
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
        vertical-align: middle;
        height: 50px;
        background: #fefefe;
        z-index: 10;
        cursor: pointer;
        right: 0;
        top: 50vh;
        position: fixed;
    }
    .ribbon-kanan p{
        /* Safari */
        -webkit-transform: rotate(90deg);

        /* Firefox */
        -moz-transform: rotate(90deg);

        /* IE */
        -ms-transform: rotate(90deg);

        /* Opera */
        -o-transform: rotate(90deg);
        margin-top: 1rem;
    }
</style>

<div class="col-xl-12 col-md-12">
    <!--begin::Charts Widget 1-->
    <div class="card mb-5 mb-xxl-8">
        <!--begin::Header-->
        <input type="hidden" id="id" value="{{$id}}"/>
        <div class="ribbon-kanan" id="btn-ubah" onclick="ubah()">
            <p>Ubah</p>
        </div>
        <div class="card-header border-0 pt-5 ribbon ribbon-top">
                
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column lp_hglt_cls_recent_statisticsmore_than_400_new_members">
                <span class="card-label fw-bolder fs-1 mb-1" id="judul">
                Bisnis Anak Usaha Krakatau Steel Mengalami Peningkatan
                </span>
                <div class="row mx-0 my-3 col-12">
                    <div class="col-12 ps-0">
                        <i class="bi bi-person-circle me-3 text-primary"></i> <span class="text-muted" id="creator">Administrator - 06 April 2021</span>
                    </div>
                <div>
            </h3>
            <!--end::Title-->
            <div class="ribbon-label d-none" id="status-ribbon" style="top:2px">Published</div>
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body" style="position: relative;">
            <div id="image-detail">
                
            </div>
            <div class="py-6">
                <p class="text-justify" id="desc">
                Direktur Utama PT Krakatau Steel Tbk (KRAS) Silmy Karim menyerukan perlunya menata kembali industri baja tanah air agar bisa bersaing dengan baja produk negara lain. Pemerintah perlu melakukan pembenahan dari sisi regulasi dan peningkatan dukungan pemerintah.
                Silmy Karim mengatakan Industri baja nasional perlu ditata kembali karena industri ini merupakan ibu dari industri. Industri baja sangat penting bagi negara yang sedang gencar melakukan pembangunan ekonomi.
                Salah satu pembenahan yang perlu dilakukan adalah revisi Peraturan Menteri Perdagangan (Permendag) No. 22 tahun 2018. Aturan ini sejatinya untuk menurunkan dueling time tetapi digunakan eksportir baja luar negeri untuk pengalihan harmonized system (HS number).
                </p>
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Charts Widget 1-->
</div>

<script src="{{asset('assets/extends/js/pages/berita-detail.js')}}"></script>
@endsection
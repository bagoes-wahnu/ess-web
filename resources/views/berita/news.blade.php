@extends('layout.main')


@section('content')
<style>
    .news-image{
        height: 300px;
        background-size: cover;
        width: 100%;
        border-radius: 8px;
    }
    .fz-13{
        font-size:18px;
    }
    .text-justify{
        text-align: justify;
    }
</style>

<div class="col-xl-12 col-md-12">
    <div class="col-xl-12 col-md-12 px-6" style="background:#fefefe;height:40px;margin-top: -40px;">
        <div class="row m-0">
            <div class="col-md-3 p-1">
                <input type="text" class="form-control p-2" id="txt-search" placeholder="Cari..." style="font-size: .925rem;"/>
            </div>
            <div class="col-md-2 p-1">
                <select class="form-select form-select-sm form-select-solid" id="select-status" data-control="select2" data-placeholder="Select an option">
                    <option value="0">Semua Status</option>
                    <option value="2">Published</option>
                    <option value="1">Draft</option>
                </select>
            </div>
            <div class="col-md-2 p-1">
                <button class="btn btn-light-primary p-3" style="font-size: .725rem;" onclick="terapkan()">Terapkan Filter</button>
            </div>
            <div class="col-md-4 p-1 text-right">
                <button class="btn btn-light-danger btn-icon" id="btn-grid" onclick="showMode('grid')" style="font-size: .725rem;"><i class="bi bi-grid-fill"></i></button>
                <button class="btn btn-light-primary btn-icon" id="btn-list" onclick="showMode('list')" style="font-size: .725rem;"><i class="bi bi-list"></i></button>
            </div>
            <div class="col-md-1 p-2">
                <a href="{{url('berita/form')}}" class="btn btn-primary p-2" style="font-size: .725rem;">Buat Berita</a>
            </div>
        </div>
    </div>
    <!--begin::Charts Widget 1-->
    <div class="card mb-5 mb-xxl-8">
        <!--begin::Body-->
        <div class="card-body pb-0" id="grid-view" style="position: relative;">
            <div class="row" id="grid-list">
                {{--<div class="col-md-4 mb-12" onclick="openDetail()">
                    <div class="news-image mb-4" style="background-image:url({{asset('assets/extends/img/news1.png')}})"></div>
                    <div>
                        <p class="fz-13 fw-bolder text-justify">Metronic Admin - How To Start the Dashboard with your custo...</p>
                    </div>
                    <div>
                        <p class="text-justify text-muted">We’ve been focused on making a the from also not been afraid to and step away been focused create eye when been afraid to ...</p>
                    </div>
                    <div class="mt-4 row mx-0">
                        <div class="col-md-8 px-0 py-1 text-muted" style="font-size:10px"><strong>Administrator</strong> - 12 Agustur 1002</div>
                        <div class="col-md-4 text-right"><span class="badge badge-light-primary">Published</span></div>
                    </div>
                </div>
                <div class="col-md-4 mb-12">
                    <div class="news-image mb-4" style="background-image:url({{asset('assets/extends/img/news1.png')}})"></div>
                    <div>
                        <p class="fz-13 fw-bolder text-justify">Metronic Admin - How To Start the Dashboard with your custo...</p>
                    </div>
                    <div>
                        <p class="text-justify">We’ve been focused on making a the from also not been afraid to and step away been focused create eye when been afraid to ...</p>
                    </div>
                </div>
                <div class="col-md-4 mb-12">
                    <div class="news-image mb-4" style="background-image:url({{asset('assets/extends/img/news1.png')}})"></div>
                    <div>
                        <p class="fz-13 fw-bolder text-justify">Metronic Admin - How To Start the Dashboard with your custo...</p>
                    </div>
                    <div>
                        <p class="text-justify">We’ve been focused on making a the from also not been afraid to and step away been focused create eye when been afraid to ...</p>
                    </div>
                </div>
                <div class="col-md-4 mb-12">
                    <div class="news-image mb-4" style="background-image:url({{asset('assets/extends/img/news1.png')}})"></div>
                    <div>
                        <p class="fz-13 fw-bolder text-justify">Metronic Admin - How To Start the Dashboard with your custo...</p>
                    </div>
                    <div>
                        <p class="text-justify">We’ve been focused on making a the from also not been afraid to and step away been focused create eye when been afraid to ...</p>
                    </div>
                </div>--}}
            </div>
        </div>
        <!--end::Body-->
        <div class="card mb-5 mb-xxl-8 d-none" id="list-view">
            <div class="card-header border-0 pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column lp_hglt_cls_recent_statisticsmore_than_400_new_members">
                    <span class="card-label fw-bolder fs-3 mb-1">All News</span>
                    <span class="text-muted fw-bold fs-7">The following is the tenant data registered in the Customer Relationship Management.</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    {{--<a class="btn btn-light-warning me-3" href="{{url('news')}}"><i class="bi bi-chevron-left me-2"></i>Back</a>
                    <a class="btn btn-primary" href="{{url('news/form')}}">New News</a>--}}
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" style="position: relative;">
                <div id="table-wrapper">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-list">
                            <tr>
                                <td>1</td>
                                <td><img src="{{asset('assets/extends/img/logo.png')}}" style="border-radius:3px"/></td>
                                <td>Promo Lokasi Menarik Harga Murah</td>
                                <td>01-05-2020</td>
                                <td>
                                    <span class="badge badge-light-primary">Published</span>
                                </td>
                                <td>
                                    <a class="" href="{{url('news/form')}}"><i class="text-warning bi bi-pencil-square me-3" style="font-size: 20px;"></i></a>
                                    <a class="" href="{{url('news/detail')}}"><i class="text-primary bi bi-info-circle-fill" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><img src="{{asset('assets/extends/img/logo.png')}}" style="border-radius:3px"/></td>
                                <td>Kawasan Industri Krakatau 1 - Cilegon</td>
                                <td>01-05-2020</td>
                                <td>
                                    <span class="badge badge-light-danger">Draft</span>
                                </td>
                                <td>
                                    <a class="" href="{{url('news/form')}}"><i class="text-warning bi bi-pencil-square me-3" style="font-size: 20px;"></i></a>
                                    <a class="" href="{{url('news/detail')}}"><i class="text-primary bi bi-info-circle-fill" style="font-size: 20px;"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
    <!--end::Charts Widget 1-->
</div>

<script src="{{asset('assets/extends/js/pages/berita.js')}}"></script>
<script>
   
</script>
@endsection
@extends('layout.main')
@section('content')
<style>
    table tr th, table tr td{
        text-align:center;
    }
    .counter{
        position: absolute;
        right: 10vw;
        top: 200px;
    }
    .counter .number{
        font-size: 3.3rem;
        font-weight: 600;
        margin-right: 10px;
    }
</style>

<div class="col-xl-12 col-md-12">
    <!--begin::Charts Widget 1-->
    <div class="card mb-5 mb-xxl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column lp_hglt_cls_recent_statisticsmore_than_400_new_members">
                <span class="card-label fw-bolder fs-3 mb-1">All News</span>
                <span class="text-muted fw-bold fs-7">The following is the tenant data registered in the Customer Relationship Management.</span>
            </h3>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <a class="btn btn-light-warning me-3" href="{{url('news')}}"><i class="bi bi-chevron-left me-2"></i>Back</a>
                <a class="btn btn-primary" href="{{url('news/form')}}">New News</a>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body" style="position: relative;">
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
                <tbody>
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
        <!--end::Body-->
    </div>
    <!--end::Charts Widget 1-->
</div>

<script src="{{asset('assets/extends/js/pages/dashboard-user.js')}}"></script>
@endsection
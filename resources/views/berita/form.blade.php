@extends('layout.main')
@section('content')
<style>
  .image-detail{
    width: 100%;
    height: 350px;
    background-repeat: no-repeat;
    background-size: cover;
    margin-bottom: 2rem;
  }
  .text-justify{
        text-align: justify;
    }
</style>
<div class="col-md-12 row m-0">
    <div class="col-xl-8 col-md-8">
        <!--begin::Charts Widget 1-->
        <div class="card mb-5 mb-xxl-8">
            <!--begin::Header-->
            <input type="hidden" id="id" value="{{$id}}"/>
            <div class="card-header border-0 pt-5">
                    
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-1 mb-1">
                    Buat Berita Baru
                    </span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar"></div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" style="position: relative;">
                <div class="row mx-0 mb-4">
                    <div class="col-md-2 py-3"><label>Tanggal</label></div>
                    <div class="col-md-10">
                        <input id="tanggal" type="text" class="form-control" readonly="readonly" placeholder="Pilih tanggal" readonly/>
                    </div>
                </div>
                <input type="text" class="form-control" id="judul" placeholder="Judul"/>
                <div class="py-4">
                    <textarea name="kt_docs_ckeditor_classic" id="kt_docs_ckeditor_classic">
                    
                    </textarea>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Charts Widget 1-->
    </div>
    <div class="col-xl-4 col-md-4">
        <!--begin::Charts Widget 1-->
        <div class="card mb-5 mb-xxl-8">
            <!--begin::Header-->
            
            <div class="card-header border-0 pt-5">
                    
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column lp_hglt_cls_recent_statisticsmore_than_400_new_members">
                    <span class="card-label fs-5 mb-1">
                    Cover / Thumbnail
                    </span>
                    
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" style="position: relative;">
                <div class="my-3 col-12 text-center">
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(assets/media/avatars/blank.png)">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/150-26.jpg)"></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" id="file-avatar" name="avatar" accept=".png, .jpg, .jpeg">
                            <input type="hidden" name="avatar_remove">
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                <div>
                <div class="col-12 mb-2 mt-10"><button onclick="simpan('2')" class="w-100 btn btn-primary">Publish</button></div>
                <div class="col-12 my-2"><button onclick="simpan('1')" class="w-100 btn btn-success">Save as Draft</button></div>
                <div class="col-12 my-2"><button onclick="simpan('1','perview')" class="w-100 btn btn-light text-primary mb-20">Preview</button></div>
                <div class="col-12 my-2"> <a class="w-100 btn btn-light-warning" href="{{url('berita')}}"><i class="bi bi-chevron-left me-2"></i>Back</a></div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Charts Widget 1-->
    </div>
</div>

<script src="{{asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js')}}"></script>
<script src="{{asset('assets/extends/js/pages/berita-form.js')}}"></script>

<script>
    
</script>
@endsection
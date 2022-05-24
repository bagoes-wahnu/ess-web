@include('layout.css')

<!--begin::Container-->
<input type="hidden" value="{{env('URL_API')}}" id="api-url"/>
<div class="container m-0 px-0" style="height:55px;background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);max-width: 100vw;">
    <div class="p-4">
        <img class="d-inline" src="{{ asset('assets/extends/img/ess-logo.png') }}">
        <img class="d-inline" src="{{ asset('assets/extends/img/ksi-ess.png') }}" style="margin-left: 12px;">
    </div>
</div>

<div class="container py-10">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5 card-header ribbon ribbon-top">
        <div class="ribbon-label status-indicator">-</div>
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:26px">SPJPK</span></br>
            </h3>
            <div class="card-toolbar">
                <h3 class="card-title align-items-start flex-column text-right">
                    <span class="card-label text-dark font-weight-bolder txt-instansi" 
                    style="margin: 0;
                    font-size: 20px;
                    width: 100%;
                    display: inline-block;">KLINIK BONA MEDIKA</span></br>
                    <span class="text-muted txt-alamat-instansi" style="font-size:16px;    
                    margin: 0;
                    width: 100%;
                    display: inline-block;">alamat</span>
                </h3>
            </div>
        </div>
        <div class="card-body pt-9 pb-0 px-15">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div class="m-0 row">
                    <input type="hidden" id="id" value="{{$id}}"/>
                    <div class="col-md-2 mb-4 ps-0">
                        <span class="text-muted">Tanggal Pengajuan</span>
                        <p class="font-weight-bolder fs-5 txt-tanggal">-</p>
                    </div>
                    <div class="col-md-2 mb-4">
                        <span class="text-muted">Berlaku Sampai</span>
                        <p class="font-weight-bolder fs-5 txt-berlaku">-</p>
                    </div>
                    <div class="col-md-2 mb-4">
                        <span class="text-muted">Istri</span>
                        <p class="font-weight-bolder fs-5 txt-istri">-</p>
                    </div>
                    <div class="col-md-2 mb-4">
                        <span class="text-muted">NP</span>
                        <p class="font-weight-bolder fs-5 txt-np">-</p>
                    </div>
                    <div class="col-md-2 mb-4">
                        <span class="text-muted">CP</span>
                        <p class="font-weight-bolder fs-5 txt-cp">-</p>
                    </div>
                    <div class="col-md-2 mb-4 pe-0 text-right">
                        <span class="text-muted">Jenis Perawatan</span>
                        <p class="font-weight-bolder fs-5"><span class="badge badge-light-primary txt-jenis">-</span></p>
                    </div>
                    <div class="col-md-12 mb-8 px-0">
                        <span class="text-muted">Alamat Rumah</span>
                        <p class="font-weight-bolder fs-5 txt-address">-</p>
                    </div>
                    <div class="col-md-3 mb-12 ps-0">
                        <p class="text-muted font-weight-bolder" style="text-transform: uppercase;">Diagnosa</p>
                        <p class="font-weight-bolder fs-5 txt-diagnosa">-</p>
                    </div>
                    <div class="col-md-6 mb-12">
                        <p class="text-muted font-weight-bolder" style="text-transform: uppercase;">Keterangan</p>
                        <p class="font-weight-bolder fs-5 txt-desc">-</p>
                    </div>
                    <div class="col-md-3 mb-12 pe-0 text-right">
                        <p class="text-muted font-weight-bolder" style="text-transform: uppercase;">Biaya</p>
                        <p class="font-weight-bolder fs-5 txt-biaya">-</p>
                    </div>
                    <div class="col-md-12 my-8 px-0" id="div-keputusan">
                        <button type="button" onclick="keputusanIzin('0')" class="btn btn-sm btn-light-danger me-4"><i class="bi bi-x-circle-fill me-3"></i>Tolak</button>
                        <button type="button" onclick="keputusanIzin('2')" class="btn btn-sm btn-light-primary"><i class="bi bi-check-circle-fill me-3"></i>Terima</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('layout.js')
<script>
    let baseUrl = "{{asset('/')}}";
    let urlApi=$('#api-url').val()
</script>
<script src="{{asset('assets/extends/js/pages/permohonan-izin-cetak.js')}}"></script>
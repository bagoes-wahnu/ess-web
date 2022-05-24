@extends('layout.main')
@section('content')

<style>
	.setting-item {
		padding:30px 20px 30px 20px; border-style:  solid; border-width: thin; border-color: #dbdada; border-radius: 18px; 
	}
	/* .table input{
        font-size:11px;
        padding:3px;
        height:25px;
        width:25px;
        text-align:center;
    }
    .table .month{
        font-size:11px;
        text-align:center;
        padding:3px !important;
    }
    .table td:first-child{
        padding:1rem;
    }
    div .pilih-jenis{
        text-align:center;
        font-size:13px;
        font-weight:bolder;
        padding: 0.7rem 0;
        color: #A2A7C3;
        cursor:pointer;
    }
    div .pilih-jenis.active{
        border-bottom:2px solid #00A1D3;
        color: #00A1D3;

    } */
</style>

<div class="container">
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Setting Skor</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan skor penilaian pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <div class="kt-portlet__body " style="margin-bottom: 80px">
                <div class="row">
                	<div class="col-md-6" style="padding:14px;">
                        <input type="hidden" id="input-1" value=""/>
                        <input type="hidden" id="input-2" value=""/>
                        <input type="hidden" id="input-3" value=""/>
                        <input type="hidden" id="input-4" value=""/>
                		<div class="text-center setting-item" style="">
                			{{-- <h3 class="text-dark font-weight-bolder d-none" id="title-1">Tambah Indikator KPI</h3> --}}
                			<h3 class="text-dark font-weight-bolder">Sasaran Kerja dan Penilaian Hasil Kerja
								<a href="javascript:;" class="btn" onclick="show_hasil()" data-toggle="m-tooltip" title="Edit " style="padding: 4px !important">
									<span class="">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="12" cy="12" r="12" fill="#FCAD00"/>
										<g clip-path="url(#clip0)">
										<path d="M12.6783 8.82144L15.1787 11.3218L9.74917 16.7513L7.51987 16.9974C7.22143 17.0304 6.96929 16.7781 7.00249 16.4796L7.25054 14.2488L12.6783 8.82144ZM16.7251 8.44917L15.5511 7.27515C15.1849 6.90894 14.591 6.90894 14.2248 7.27515L13.1203 8.37964L15.6207 10.88L16.7251 9.77554C17.0914 9.40913 17.0914 8.81538 16.7251 8.44917Z" fill="white"/>
										</g>
										<defs>
										<clipPath id="clip0">
										<rect width="10" height="10" fill="white" transform="translate(7 7)"/>
										</clipPath>
										</defs>
										</svg>
									</span>
								</a>
							</h3>
                			<span class="text-success bg-light-success fw-bolder" style="font-size:12px">&nbsp; Sudah Terisi &nbsp;</span>
                		</div>
                	</div>
                	<div class="col-md-6" style="padding:14px;">
                		<div class=" text-center setting-item" style="">
							{{-- <h3 class="text-dark font-weight-bolder d-none" id="title-2">Setting Skor</h3> --}}
                			<h3 class="text-dark font-weight-bolder">Penilaian Perilaku Kerja
								<a href="javascript:;" class="btn" onclick="show_perilaku()" data-toggle="m-tooltip" title="Tambah " style="padding: 4px !important">
									<span class="">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="12" cy="12" r="12" fill="#FCAD00"/>
										<g clip-path="url(#clip0)">
										<path d="M12.6783 8.82144L15.1787 11.3218L9.74917 16.7513L7.51987 16.9974C7.22143 17.0304 6.96929 16.7781 7.00249 16.4796L7.25054 14.2488L12.6783 8.82144ZM16.7251 8.44917L15.5511 7.27515C15.1849 6.90894 14.591 6.90894 14.2248 7.27515L13.1203 8.37964L15.6207 10.88L16.7251 9.77554C17.0914 9.40913 17.0914 8.81538 16.7251 8.44917Z" fill="white"/>
										</g>
										<defs>
										<clipPath id="clip0">
										<rect width="10" height="10" fill="white" transform="translate(7 7)"/>
										</clipPath>
										</defs>
										</svg>
									</span>
								</a>
							</h3>
                			<span class="text-danger bg-light-danger fw-bolder" style="font-size:12px">&nbsp; Belum Terisi &nbsp;</span>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-edit">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting Skor</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
					</span>
                </div>
            </div>
            <div class="modal-body">
				<h3 class="text-primary mb-10">Sasaran Kerja dan Penilaian Hasil Kerja</h3>
				<h6 class="text-gray-600">Silahkan menambahkan ukuran prestasi kerja pada form berikut ini.</h6>
				<div class="kt-portlet__body">
					<div id="table-wrapper">
						<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="table-setting-skor">
						</table>
					</div>
				</div>
            </div>
            <div class="modal-footer" id="footer-edit">
            </div>
        </div>
    </div>
</div> 

<script src="{{asset('assets/extends/js/pages/setting-skor.js')}}"></script>

@endsection
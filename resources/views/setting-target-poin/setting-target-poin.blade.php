@extends('layout.main')
@section('content')

<style>
	.setting-item {
		padding:30px 20px 30px 20px; border-style:  solid; border-width: thin; border-color: #dbdada; border-radius: 18px; 
	}
</style>

<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Setting Target Poin Tahunan</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan setting target poin tahunan pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body " style="margin-bottom: 80px">
                <div class="row">
                    <input type="hidden" id="input-5" value=""/>
                    <input type="hidden" id="input-6" value=""/>
                	<div class="col-md-3" style="padding:14px;">
                		<div class=" text-center setting-item" style="">
                			<h3 class="text-dark font-weight-bolder ">Target Poin Tahunan</h3>
                			<span class="text-muted" style="font-size:12px">Batas atas target poin tahunan</span>
                			<h1 class=" font-weight-bolder mt-1" >
                				<span style="color: #00A1D3" class="data-5"> - Poin </span> 
                				<a href="javascript:;" class="btn" onclick="editSetting('5')" data-toggle="m-tooltip" title="Edit " style="padding: 4px !important">
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
                				
	                		</h1>
                		</div>
                	</div>
                	<div class="col-md-3" style="padding:14px;">
                		<div class=" text-center setting-item" style="">
                			<h3 class="text-dark font-weight-bolder ">Target CSR</h3>
                			<span class="text-muted" style="font-size:12px">Batas atas target CSR</span>
                			<h1 class=" font-weight-bolder mt-1" >
                				<span style="color: #00A1D3" class="data-6"> - Jam </span> 
                				<a href="javascript:;" class="btn" onclick="editSetting('6')" data-toggle="m-tooltip" title="Edit " style="padding: 4px !important">
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
                				
	                		</h1>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Target <span class="text-pembilang">Poin Tahunan</span></h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
                <form id="form-input">
                    <label for="nama" class="form-label">Masukkan jumlah <span class="text-pembilang">Poin Maksimal Tahunan</span></label>
                    <div class="input-group  mt-4">
                        <input type="text" class="form-control " id="hari-maksimal" placeholder="Cth: 3"/>
                        <div class="input-group-append bg-secondary">
                            <span class="input-group-text text-muted pembilang">
                               Poin
                            </span>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan()">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
            </div>
            </form>
        </div>
    </div>
</div> 

<script src="{{asset('assets/extends/js/pages/setting-izin.js')}}"></script>

<script>

jQuery(document).ready(function($) {

	
});	

// function editSetting() {
// 	$('#modal').modal('show')
// }

</script>






@endsection
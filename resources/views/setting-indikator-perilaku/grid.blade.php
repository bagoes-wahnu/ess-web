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
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Setting Indikator Perilaku Penilaian <span class="d-none" id="year">: &nbsp; <span id="year-text"></span></span></span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan indikator perilaku penilaian pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
				<button type="button" id="btn-kembali" class="btn btn-secondary me-5 d-none" onclick="show()">
					<span class="svg-icon svg-icon-muted svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="black"/>
						</svg>
					</span>
					Kembali
				</button>
				<div id="btn-simpan-setting">

				</div>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
			<input type="hidden" id="id-tahun" value=""/>
            <div class="kt-portlet__body " style="margin-bottom: 30px" id="grid-view">
                <div class="row">
					<div class="col-md-3" style="padding:14px;">
                        <input type="hidden" id="input-1" value=""/>
                        <input type="hidden" id="input-2" value=""/>
                        <input type="hidden" id="input-3" value=""/>
                        <input type="hidden" id="input-4" value=""/>
						<a type="button" class="text-primary bg-light-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
							<div class="btn btn-outline btn-outline-dashed btn-outline-default active text-center setting-item text-primary bg-light-primary" style="">
								<span class="svg-icon svg-icon-primary svg-icon-4x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path opacity="0.3" d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 11H13V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
									<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM17 11H13V7C13 6.4 12.6 6 12 6C11.4 6 11 6.4 11 7V11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="black"/>
									</svg>
								</span>
								<h3 class="font-weight-boldest mt-5 mb-0" id="title-1">Tambah Data</h3>
								<span style="font-size:10px">Klik untuk menambah tahun baru</span>
							</div>
						</a>
                	</div>
                	<div class="col-md-3" style="padding:14px;">
                        <input type="hidden" id="input-1" value=""/>
                        <input type="hidden" id="input-2" value=""/>
                        <input type="hidden" id="input-3" value=""/>
                        <input type="hidden" id="input-4" value=""/>
                		<div class=" text-center setting-item" style="">
                			<h1 class="text-dark font-weight-boldest mb-5" id="title-1">2022</h1>
                			<h1 class=" font-weight-bolder mt-1" >
								<div class="d-flex ms-15">
									<div class="form-check form-switch form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" checked="checked" value=""/>
										<label class="form-check-label" for="chk-switch"></label>
									</div>
									<a href="javascript:;" class="btn" data-bs-toggle="modal" data-bs-target="#modal-edit" style="padding: 4px !important">
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
								</div>
	                		</h1>
                		</div>
                	</div>
                	<div class="col-md-3" style="padding:14px;">
                        <input type="hidden" id="input-1" value=""/>
                        <input type="hidden" id="input-2" value=""/>
                        <input type="hidden" id="input-3" value=""/>
                        <input type="hidden" id="input-4" value=""/>
                		<div class=" text-center setting-item" style="">
                			<h1 class="text-dark font-weight-boldest mb-5" id="title-1">2021</h1>
                			{{-- <span class="text-muted" style="font-size:12px">Batas atas izin tanpa keterangan</span> --}}
                			<h1 class=" font-weight-bolder mt-1" >
								<div class="d-flex ms-15">
									<div class="form-check form-switch form-check-custom form-check-solid">
										{{-- <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/> --}}
										<input class="form-check-input" type="checkbox" checked="checked" value=""/>
										<label class="form-check-label" for="chk-switch"></label>
									</div>
									<a href="javascript:;" class="btn" onclick="editSetting('1')" data-toggle="m-tooltip" title="Edit " style="padding: 4px !important">
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
								</div>
	                		</h1>
                		</div>
                	</div>
                	<div class="col-md-3" style="padding:14px;">
                        <input type="hidden" id="input-1" value=""/>
                        <input type="hidden" id="input-2" value=""/>
                        <input type="hidden" id="input-3" value=""/>
                        <input type="hidden" id="input-4" value=""/>
                		<div class=" text-center setting-item" style="">
                			<h1 class="text-dark font-weight-boldest mb-5" id="title-1">2020</h1>
                			{{-- <span class="text-muted" style="font-size:12px">Batas atas izin tanpa keterangan</span> --}}
                			<h1 class=" font-weight-bolder mt-1" >
								<div class="d-flex ms-15">
									<div class="form-check form-switch form-check-custom form-check-solid">
										{{-- <input class="form-check-input" type="checkbox" value="" onclick="changeStatus()"/> --}}
										<input class="form-check-input" type="checkbox" checked="checked" value=""/>
										<label class="form-check-label" for="chk-switch"></label>
									</div>
									<a href="javascript:;" class="btn" onclick="editSetting('1')" data-toggle="m-tooltip" title="Edit " style="padding: 4px !important">
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
								</div>
	                		</h1>
                		</div>
                	</div>
                </div>
            </div>
			<div class="kt-portlet__body d-none" style="margin-bottom: 30px" id="edit-view">
				<div id="id-setting">
					{{-- <div class="d-flex flex-column fv-row mb-2">
						<label class="fs-5 fw-bold mb-2">Tata Nilai</label>
						<div class="d-flex">
							<div class="col-11 me-10" id="indicator-add">
								<select class="form-select" id="select-indicator-edit" data-control="select2" data-placeholder="Pilih Tata Nilai">
								</select>
							</div>
							<div class="col-1" id="row-indicator">
								<button class="btn btn-icon btn-danger btn-active-light-danger" onclick="removeEditor('`+res[r].id+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Indicator">
									<i class="bi bi-dash-lg"></i>
								</button>
							</div>
						</div>
					</div>
					<table class="table gs-0 gy-1" id="table-setting-skor">
						<thead>
							<tr class="fs-5 fw-bold">
								<th scope="col" style="width:30%">Aspek Perilaku</th>
								<th scope="col" style="width:30%">Bobot (%)</th>
								<th scope="col" style="width:30%">Target</th>
								<th scope="col" style="width:10%"></th>
							</tr>
						</thead>
						<tbody id="kolom-skor">
						</tbody>
					</table> --}}
				</div>
				{{-- <div class="row mb-5">
					<div class="col-md-5 fv-row">
						<label class="fs-5 fw-bold mt-5 mb-2">Prespektif</label>
						<input type="text" class="form-control" placeholder="Cth: Pengendalian biaya cost center" id="nama-prespektif" name="nama-prespektif" />
					</div>
					<div class="col-md-5 fv-row">
						<label class="fs-5 fw-bold mt-5 mb-2">Unit Prespektif</label>
						<input type="text" class="form-control" placeholder="Cth: Min %" id="unit-prespektif" name="unit-prespektif" />
					</div>
					<div class="col-md-2 fv-row mt-15">
						<button class="btn btn-icon btn-danger btn-active-light-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
							<i class="bi bi-plus-lg"></i>
						</button>
					</div>
				</div> --}}
            </div>
			<div id="btn-tambah-nilai">
				{{-- <button type="button" class="btn btn-primary" onclick="tambah()">Tambah Tata Nilai</button> --}}
			</div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tahun</h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						</svg>
					</span>
                </div>
            </div>

            <div class="modal-body">
				<input type="hidden" id="id" value=""/>
				<label for="nama" class="form-label">Tahun</label>
				<input type="text" class="form-control" id="tahun" placeholder="Pilih Tahun" readonly/>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-simpan" class="btn btn-primary" onclick="simpan_tahun()">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Proses menyimpan...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-edit">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tahun</h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
						</svg>
					</span>
                </div>
            </div>

            <div class="modal-body">
				<input type="hidden" id="id" value=""/>
				<label for="nama" class="form-label font-weight-bolder">Tahun</label>
				<input type="text" class="form-control mb-5" id="tahun-edit" placeholder="Pilih Tahun" value="2021" readonly/>
				<label for="hapus" class="form-label text-danger font-weight-bolder">Hapus Tahun</label>
				<div id="hapus-tahun">
					<label id="label-tahun" class="rounded border-secondary border border-dashed bg-light-danger d-flex text-start p-6 ms-0 me-2">
						<span class="form-check form-check-custom form-check-danger align-items-middle mt-1">
							<input id="checkbox-tahun" class="form-check-input menu-1" type="checkbox" name="type" value=""/>
						</span>
						<span class="ms-5 mt-2">
							<span class="fs-4 fw-bolder text-gray-800 mb-1 d-block">Hapus Tahun</span>
							<span id="text-tahun" class="text-danger" style="font-size:12px">Perhatikan baik baik, memilih ini akan menghapus seluruh data didalamnya</span>
						</span>
					</label>
				</div>
            </div>

            <div class="modal-footer" id="footer-edit">
                
            </div>
        </div>
    </div>
</div> 

<script src="{{asset('assets/extends/js/pages/setting-indikator-perilaku.js')}}"></script>

@endsection
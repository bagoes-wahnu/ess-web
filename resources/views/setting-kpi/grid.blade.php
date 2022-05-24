@extends('layout.main')
@section('content')

<style>
	.setting-item {
		padding:30px 20px 30px 20px; border-style:  solid; border-width: thin; border-color: #dbdada; border-radius: 18px; 
	}
</style>
<div class="container">
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Setting KPI <span class="d-none" id="year">: &nbsp; <span id="year-text"></span></span></span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan setting kpi pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
				<button type="button" id="btn-simpan" class="btn btn-secondary me-5 d-none" onclick="tambah()">
					<span class="svg-icon svg-icon-muted svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
						<path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="black"/>
						</svg>
					</span>
					Kembali
				</button>
				<button type="button" id="btn-simpan" class="btn btn-success d-none" onclick="tambah()">
					Simpan Semua
				</button>
            </div>
        </div>
        <div class="card-body">
			<input type="hidden" id="id-tahun" value=""/>
            <div class="kt-portlet__body " style="margin-bottom: 30px" id="grid-view">
               
            </div>
			<div class="kt-portlet__body d-none" style="margin-bottom: 30px" id="edit-view">
				<div class="d-flex flex-column fv-row mb-2">
					<label class="fs-5 fw-bold mb-2">Divisi</label>
					<div class="d-flex">
						<div class="col-6 me-10" id="indicator-add">
							<select class="form-select" id="select-indicator-edit" data-control="select2" data-placeholder="Pilih Divisi">
							</select>
						</div>
						<div class="col-6">
							<button class="btn btn-light-primary btn-active-light-primary">
								Tampilkan
							</button>
						</div>
					</div>
				</div>
				<div class="tab-pane fade show active menu-form-pilih">
					<div class="card">
						<div class="card-body">
							<div class="text-center px-5">
								<img src="{{asset('assets/media/illustrations/Group.png')}}" alt="" class="mw-100 h-200px h-sm-200px" />
								<p class="text-gray-400 fs-4 fw-bold py-0">
								<br />Silahkan pilih divisi terlebih dahulu</p>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-20 tab-pane fade show active menu-form d-none">
					<div class="d-flex flex-column fv-row mb-2">
						<label class="fs-5 fw-bold mb-2">Jenis Parameter</label>
						<div class="d-flex">
							<div class="col-11 me-10" id="parameter-edit">
								<select class="form-select" id="select-parameter-edit" data-control="select2" data-placeholder="Pilih Jenis Parameter">
								</select>
							</div>
							<div class="col-1">
								<button class="btn btn-icon btn-danger btn-active-light-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Skor">
									<i class="bi bi-dash-lg"></i>
								</button>
							</div>
						</div>
					</div>
					<table class="table gs-0 gy-1" id="table-setting-skor">
						<thead>
							<tr class="fs-5 fw-bold">
								<th scope="col" style="width:35%">Prespektif</th>
								<th scope="col" style="width:15%">Bobot (%)</th>
								<th scope="col" style="width:15%">Target SKK</th>
								<th scope="col" style="width:15%">Target IKU</th>
								<th scope="col" style="width:20%"></th>
							</tr>
						</thead>
						<tbody id="kolom-skor">
							<tr class="data-new" id="data-">
								<td>
									<select class="form-select" id="select-indicator-1" data-control="select2" data-placeholder="Pilih Tata Nilai">
									</select>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td class="text-center">
									<button class="btn btn-icon btn-success btn-active-light-primary" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
										<i class="bi bi-plus-lg"></i>
									</button>
								</td>
							</tr>
							<tr class="data-new" id="data-">
								<td>
									<select class="form-select" id="select-indicator-2" data-control="select2" data-placeholder="Pilih Tata Nilai">
									</select>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td>
									<input type="text" class="form-control score_min" placeholder="Cth: 100"/>
								</td>
								<td class="text-center">
									<button class="btn btn-icon btn-danger btn-active-light-danger" onclick="openEditor('new_create', '`+id_temporary+`')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
										<i class="bi bi-dash-lg"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
					<button type="button" id="btn-simpan" class="btn btn-primary" onclick="tambah()">Tambah Parameter</button>
				</div>
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
					<label id="" class="rounded border-danger border border-dashed bg-light-danger d-flex text-start p-6 ms-0 me-2">
						<span class="form-check form-check-custom form-check-danger form-check-sm align-items-middle mt-1">
							<input id="checkbox-tahun" class="form-check-input menu-1" type="checkbox" name="type" value="" />
						</span>
						<span class="ms-5 mt-2">
							<span class="fs-4 fw-bolder text-gray-800 mb-1 d-block">Hapus Tahun</span>
							<span class="text-danger" style="font-size:12px">Perhatikan baik baik, memilih ini akan menghapus seluruh data didalamnya</span>
						</span>
					</label>
            </div>

            <div class="modal-footer" id="footer-edit">
                
            </div>
        </div>
    </div>
</div> 

<script src="{{asset('assets/extends/js/pages/setting-kpi.js')}}"></script>

@endsection
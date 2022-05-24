@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Target Nilai Tahun 2021 Divisi Design</span></br>
                <span class="text-muted" style="font-size:16px">Silahkan melengkapi target nilai SKK dan IKU pada divisi design pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" id="btn-simpan" class="btn btn-light-warning btn-sm me-3" onclick="history.back()"><i class="bi bi-chevron-left me-2"></i>Kembali</button>
                <button type="button" id="btn-simpan" class="btn btn-success btn-sm">Simpan Semua</button>
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">

            	{{-- <div class="row" style="position: absolute;z-index: 9;right: 22vw;"> 
		            <div class=" col-md-4 form-group" >
		                <input type="text" class="form-control" name="" id="filter-bulan" placeholder="semua bulan" readonly="">
		            </div>
		        </div> --}}

                <div id="table-wrapper">
                	<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col" style="width:50%">Jenis Parameter</th>
	                			<th scope="col">Unit</th>
	                			<th scope="col" style="width:100px">Target Nilai SKK</th>
                                <th scope="col" style="width:100px">Target Nilai SKK</th>
	                			<th scope="col">Aksi</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td colspan="5"><h5>FINANCE & MARKET</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Pengendalian biaya cost center (by konsultan, by rapat, consumable, dll)</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>

                            <tr>
	                			<td colspan="5"><h5>CUSTOMER</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Melakukan Pendampingan Perizinan Investor</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Menyelesaikan Sertifikat Baru Investor & Sertifikat Perpanjangan Investor</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>

                            <tr>
	                			<td colspan="5"><h5>EFFECTIVE PROCESS & OUTCOMES</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Mengurus perizinan KIEC (Investasi Baru)</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Mengurus perizinan PT. KIEC (Izin Lama/Perpanjangan)</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Membuat laporan kegiatan penanaman modal perusahaan </div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>

                            <tr>
	                			<td colspan="5"><h5>WORK FORCE</h5></td>
	                		</tr>
                            <tr>
                                <td><div class="ps-6">Mentoring</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="ps-6">Efektivitas Jam Kerja Rata-Rata / Kary (Rata-rata kehadiran)</div></td>
	                			<td class="text-center">Min %</td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
                                <td class="text-center"><input type="text" class="form-control" placeholder="Cth: 0"/></td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="targetNilai()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Target Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#F1416C" fill-rule="nonzero"/>
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#F1416C" opacity="0.3"/>
                                            </g>
                                        </svg>
	                				</button>
                                </td>
                            </tr>
	                	</tbody>
                	</table>
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

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form id="form-input">
                <div class="modal-body">
                    <input type="hidden" id="id" >
                    <div class="form-group  mb-4">
                        <label for="nama" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="tahun" readonly="readonly" placeholder="Pilih Tahun" />
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



<script src="{{asset('assets/extends/js/pages/tahun.js')}}"></script>






@endsection
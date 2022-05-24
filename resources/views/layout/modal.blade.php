		{{-- modal setting --}}

		{{-- <div class="modal fade" tabindex="-1" id="modal-setting">
		    <div class="modal-dialog ">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Pengaturan Aplikasi</h5>

		                <!--begin::Close-->
		                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
		                    <span class="svg-icon svg-icon-2x"></span>
		                </div>
		                <!--end::Close-->
		            </div>

		            <div class="modal-body">
		                <form action="">
		                    <div class="form-group  mt-3">
		                        <label for="nama" class="form-label">Nama Dinas</label>
		                        <input type="text" class="form-control " id="nama" placeholder=" "/>
		                    </div>
		                    <div class="form-group  mt-6">
		                        <label for="nama-kepala-dinas" class="form-label">Nama Kepala Dinas</label>
		                        <input type="text" class="form-control " id="nama-kepala-dinas"  placeholder=""/>
		                    </div>
		                    <div class="form-group  mt-6">
		                        <label for="nip" class="form-label">NIP Kepala Dinas</label>
		                        <input type="text" class="form-control " id="nip"  placeholder=""/>
		                    </div>
		                    <div class="form-group  mt-6">
		                        <label for="jabatan" class="form-label">Jabatan</label>
			                       <select class="form-select" id="jabatan" aria-label="Select example">
	                                    <option>Pilih Jabatan</option>
	                                    <option value="1" selected>Kepala Dinas</option>
	                                    <option value="2">Perawat terampil</option>
	                                    <option value="3">Perawat mahir</option>
	                                </select>
		                    </div>
		            </div>

		            <div class="modal-footer">
		                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
		                <button type="button" class="btn btn-sm btn-warrning">Simpan Perubahan</button>
		            </div>



		            </form>
		        </div>
		    </div>
		</div> 
 --}}




        {{-- modal change password --}}
        <div class="modal fade" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" id="modal-password">
		    <div class="modal-dialog ">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Ubah Sandi</h5>

		                <!--begin::Close-->
		                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
		                    <span class="svg-icon svg-icon-2x"></span>
		                </div>
		                <!--end::Close-->
		            </div>

		            <div class="modal-body">
		                <form action="">
		                    <div class="form-group  mt-3">
		                        <label for="old-pass" class="form-label">Sandi Lama</label>
                                <div class="input-group">
                                    <input id="inp-eye1" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
                                    <div class="input-group-append" id="btn-eye1">
                                        <span class="input-group-text" style="padding: 1.1rem;"><i id="i-eye1" class="la la-eye-slash icon-lg"></i></span>
                                    </div>
                                </div>
		                    </div>
		                    <div class="form-group  mt-6">
		                        <label for="new-pass" class="form-label">Sandi Baru</label>
                                <div class="input-group">
                                    <input id="inp-eye2" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
                                    <div class="input-group-append" id="btn-eye2">
                                        <span class="input-group-text"  style="padding: 1.1rem;"><i id="i-eye2" class="la la-eye-slash icon-lg"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger" id="lbl-eye2"></span>
		                    </div>
		                    <div class="form-group  mt-6">
		                        <label for="confirm-new-pass" class="form-label">Konfirmasi Sandi Baru</label>
                                <div class="input-group">
                                    <input id="inp-eye3" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
                                    <div class="input-group-append" id="btn-eye3">
                                        <span class="input-group-text"  style="padding: 1.1rem;"><i id="i-eye3" class="la la-eye-slash icon-lg"></i></span>
                                    </div>
                                </div>
		                    </div>
		                </div>

                        <div class="modal-footer">
                            <div class="pt-15 text-right">
                                <button type="button" id="btn-cancel" class="btn btn-secondary me-3" data-bs-dismiss="modal">Batal</button>
                                <button type="button" id="btn-ubah-sandi" class="btn btn-primary" onclick="simpanUbahSandi()">
                                    <span class="indicator-label">Simpan</span>
                                    <span class="indicator-progress">Proses menyimpan...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>
		            </form>
		        </div>
		    </div>
		</div> 

        


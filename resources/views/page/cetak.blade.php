@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Cetak</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan cetak pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            

	<!-- START -->
	<div class="">
		<!--begin::Header-->
		<div class="card-header border-0 pt-5">
			<ul class="nav">
				<li class="nav-item">
					<a style="font-size: 15px;" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bolder px-4 me-1" id="nav_1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_1">Rekab Absensi</a>
				</li>
				<li class="nav-item">
					<a style="font-size: 15px;" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" id="nav_2" data-bs-toggle="tab" href="#kt_table_widget_5_tab_2">Rekab Lembur</a>
				</li>
				<li class="nav-item">
					<a style="font-size: 15px;" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" id="nav_3" data-bs-toggle="tab" href="#kt_table_widget_5_tab_3">Rekab Poin</a>
				</li>
			</ul>
			<div class="card-toolbar">
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body py-3">
			<div class="tab-content">
				<!--begin::Tap pane-->
				<div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
					<div class="row mt-10 mb-7">
						<div class="col-md-12">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label text-dark font-weight-bolder" style="font-size:20px">Cetak Rekab Absensi</span></br>
								<span class="text-muted" style="font-size:14px">Berikut merupakan cetak rekab absensi pada aplikasi KSI - ESS</span>
							</h3>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-2 py-5">
							Tanggal Awal
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="tanggal-awal" placeholder="Pilih tanggal"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
                    		</div>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md-2 py-5">
							Tanggal Akhir
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="tanggal-akhir" placeholder="Pilih tanggal"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-10">
						<div class="col-md-2 py-5">
							
						</div>
						<div class="col-md-4">
							<button type="button" id="btn-cetak" class="btn btn-primary" onclick="openFiles('1')">
								<i>
									<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.50001 16.3334C1.36363 16.3334 1.28884 16.2901 1.24939 16.2507C1.20995 16.2113 1.16667 16.1365 1.16667 16.0001C1.16667 15.8637 1.20995 15.7889 1.24939 15.7495C1.28884 15.71 1.36363 15.6667 1.50001 15.6667H16.5C16.6364 15.6667 16.7112 15.71 16.7506 15.7495C16.7901 15.7889 16.8333 15.8637 16.8333 16.0001C16.8333 16.1365 16.7901 16.2113 16.7506 16.2507C16.7112 16.2901 16.6364 16.3334 16.5 16.3334H1.50001ZM9.33334 1.00008V9.16677H8.66667V1.00008C8.66667 0.863705 8.70995 0.788912 8.74939 0.749468C8.78884 0.710024 8.86363 0.666748 9.00001 0.666748C9.13638 0.666748 9.21117 0.710024 9.25062 0.749468C9.29006 0.788912 9.33334 0.863705 9.33334 1.00008Z" fill="white" stroke="white"/>
									</svg>
								</i>
								<span class="indicator-label">Download</span>
							</button>
						</div>
					</div>
				</div>
				<!--end::Tap pane-->
				<!--begin::Tap pane-->
				<div class="tab-pane fade" id="kt_table_widget_5_tab_2">
					<div class="row mt-10 mb-7">
						<div class="col-md-12">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label text-dark font-weight-bolder" style="font-size:20px">Cetak Rekab Lembur</span></br>
								<span class="text-muted" style="font-size:14px">Berikut merupakan cetak rekab lembur pada aplikasi KSI - ESS</span>
							</h3>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-2 py-5">
							Tanggal Awal
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="tanggal-awal1" placeholder="Pilih tanggal"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
                    		</div>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md-2 py-5">
							Tanggal Akhir
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="tanggal-akhir1" placeholder="Pilih tanggal"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-10">
						<div class="col-md-2 py-5">
							
						</div>
						<div class="col-md-4">
							<button type="button" id="btn-cetak" class="btn btn-primary" onclick="openFiles('2')">
								<i>
									<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.50001 16.3334C1.36363 16.3334 1.28884 16.2901 1.24939 16.2507C1.20995 16.2113 1.16667 16.1365 1.16667 16.0001C1.16667 15.8637 1.20995 15.7889 1.24939 15.7495C1.28884 15.71 1.36363 15.6667 1.50001 15.6667H16.5C16.6364 15.6667 16.7112 15.71 16.7506 15.7495C16.7901 15.7889 16.8333 15.8637 16.8333 16.0001C16.8333 16.1365 16.7901 16.2113 16.7506 16.2507C16.7112 16.2901 16.6364 16.3334 16.5 16.3334H1.50001ZM9.33334 1.00008V9.16677H8.66667V1.00008C8.66667 0.863705 8.70995 0.788912 8.74939 0.749468C8.78884 0.710024 8.86363 0.666748 9.00001 0.666748C9.13638 0.666748 9.21117 0.710024 9.25062 0.749468C9.29006 0.788912 9.33334 0.863705 9.33334 1.00008Z" fill="white" stroke="white"/>
									</svg>
								</i>
								<span class="indicator-label">Download</span>
							</button>
						</div>
					</div>
				</div>
				<!--end::Tap pane-->
				<!--begin::Tap pane-->
				<div class="tab-pane fade" id="kt_table_widget_5_tab_3">
					
					<div class="row mt-10 mb-7">
						<div class="col-md-12">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label text-dark font-weight-bolder" style="font-size:20px">Cetak Rekab Poin</span></br>
								<span class="text-muted" style="font-size:14px">Berikut merupakan cetak rekab poin pada aplikasi KSI - ESS</span>
							</h3>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-2 py-5">
							Divisi
						</div>
						<div class="col-md-4">
                            <select class="form-select" id="divisi" data-control="select2" data-placeholder="Pilih divisi">
                            </select>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-2 py-5">
							Tahun
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="tahun" placeholder="Pilih tahun"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
                    		</div>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-2 py-5">
							Bulan Awal
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="bulan-awal" placeholder="Pilih bulan"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
                    		</div>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md-2 py-5">
							Bulan Akhir
						</div>
						<div class="col-md-4">
							<div class="input-group  mt-4">
								<input type="text" class="form-control " id="bulan-akhir" placeholder="Pilih bulan"/>
								<div class="input-group-append bg-secondary">
									<span class="input-group-text text-muted">
										<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0 18.125C0 19.1602 0.863839 20 1.92857 20H16.0714C17.1362 20 18 19.1602 18 18.125V7.5H0V18.125ZM2.57143 10.625C2.57143 10.2812 2.86071 10 3.21429 10H7.07143C7.425 10 7.71429 10.2812 7.71429 10.625V14.375C7.71429 14.7188 7.425 15 7.07143 15H3.21429C2.86071 15 2.57143 14.7188 2.57143 14.375V10.625ZM16.0714 2.5H14.1429V0.625C14.1429 0.28125 13.8536 0 13.5 0H12.2143C11.8607 0 11.5714 0.28125 11.5714 0.625V2.5H6.42857V0.625C6.42857 0.28125 6.13929 0 5.78571 0H4.5C4.14643 0 3.85714 0.28125 3.85714 0.625V2.5H1.92857C0.863839 2.5 0 3.33984 0 4.375V6.25H18V4.375C18 3.33984 17.1362 2.5 16.0714 2.5Z" fill="#B5B5C3"/>
										</svg>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-10">
						<div class="col-md-2 py-5">
							
						</div>
						<div class="col-md-4">
							<button type="button" id="btn-cetak" class="btn btn-primary" onclick="openFiles('3')">
								<i>
									<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.50001 16.3334C1.36363 16.3334 1.28884 16.2901 1.24939 16.2507C1.20995 16.2113 1.16667 16.1365 1.16667 16.0001C1.16667 15.8637 1.20995 15.7889 1.24939 15.7495C1.28884 15.71 1.36363 15.6667 1.50001 15.6667H16.5C16.6364 15.6667 16.7112 15.71 16.7506 15.7495C16.7901 15.7889 16.8333 15.8637 16.8333 16.0001C16.8333 16.1365 16.7901 16.2113 16.7506 16.2507C16.7112 16.2901 16.6364 16.3334 16.5 16.3334H1.50001ZM9.33334 1.00008V9.16677H8.66667V1.00008C8.66667 0.863705 8.70995 0.788912 8.74939 0.749468C8.78884 0.710024 8.86363 0.666748 9.00001 0.666748C9.13638 0.666748 9.21117 0.710024 9.25062 0.749468C9.29006 0.788912 9.33334 0.863705 9.33334 1.00008Z" fill="white" stroke="white"/>
									</svg>
								</i>
								<span class="indicator-label">Download</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end::Body-->
	</div>
	<!-- END -->

        </div>
    </div>
</div>


<script src="{{asset('assets/extends/js/pages/cetak.js')}}"></script>

<script>

	

jQuery(document).ready(function($) {

	
});	

function resetPass() {
	Swal.fire({
        title: 'Reset Password?',
        text: "Password user akan dikembalikan ke default password (ESS-1234)",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F64E60',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Reset',
        
    }).then((isConfirm) => {

        if (isConfirm.isConfirmed == true) { 
        }
    })
}

</script>






@endsection
@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Pengajuan Cuti</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan Pengajuan Cuti pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
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
	                			<th scope="col">No</th>
	                			<th scope="col">Nama</th>
	                			<th scope="col">Jabatan</th>
	                			<th scope="col">Action</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td class="text-center">1</td>
	                			<td>Salahuddin Al-ayyubi</td>
	                			<td class="text-center">Admin Keuangan</td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary">
	                					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.33331 7.3335C5.99017 7.3335 7.33331 5.99035 7.33331 4.3335C7.33331 2.67664 5.99017 1.3335 4.33331 1.3335C2.67646 1.3335 1.33331 2.67664 1.33331 4.3335C1.33331 5.99035 2.67646 7.3335 4.33331 7.3335Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M8.66665 4.3335C8.66665 2.66683 9.99998 1.3335 11.6666 1.3335C13.3333 1.3335 14.6666 2.66683 14.6666 4.3335C14.6666 6.00016 13.3333 7.3335 11.6666 7.3335C9.99998 7.3335 8.66665 6.00016 8.66665 4.3335ZM4.33331 14.6668C5.99998 14.6668 7.33331 13.3335 7.33331 11.6668C7.33331 10.0002 5.99998 8.66683 4.33331 8.66683C2.66665 8.66683 1.33331 10.0002 1.33331 11.6668C1.33331 13.3335 2.66665 14.6668 4.33331 14.6668ZM11.6666 14.6668C13.3333 14.6668 14.6666 13.3335 14.6666 11.6668C14.6666 10.0002 13.3333 8.66683 11.6666 8.66683C9.99998 8.66683 8.66665 10.0002 8.66665 11.6668C8.66665 13.3335 9.99998 14.6668 11.6666 14.6668Z" fill="#00A1D3"/>
										</svg>
	                				</button>

	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary">
	                					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14 14.6668H1.99998C1.59998 14.6668 1.33331 14.4002 1.33331 14.0002C1.33331 13.6002 1.59998 13.3335 1.99998 13.3335H14C14.4 13.3335 14.6666 13.6002 14.6666 14.0002C14.6666 14.4002 14.4 14.6668 14 14.6668ZM8.66665 8.93351V2.00016C8.66665 1.60016 8.39998 1.3335 7.99998 1.3335C7.59998 1.3335 7.33331 1.60016 7.33331 2.00016V8.93351H8.66665Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M4.66669 8.93359H11.3334L8.46668 11.8003C8.20002 12.0669 7.80002 12.0669 7.53336 11.8003L4.66669 8.93359Z" fill="#00A1D3"/>
										</svg>
	                				</button>

	                			</td>
	                		</tr>

	                		<tr>
	                			<td class="text-center">2</td>
	                			<td>John F. Kenneddy</td>
	                			<td class="text-center">Staff Administrasi</td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary">
	                					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.33331 7.3335C5.99017 7.3335 7.33331 5.99035 7.33331 4.3335C7.33331 2.67664 5.99017 1.3335 4.33331 1.3335C2.67646 1.3335 1.33331 2.67664 1.33331 4.3335C1.33331 5.99035 2.67646 7.3335 4.33331 7.3335Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M8.66665 4.3335C8.66665 2.66683 9.99998 1.3335 11.6666 1.3335C13.3333 1.3335 14.6666 2.66683 14.6666 4.3335C14.6666 6.00016 13.3333 7.3335 11.6666 7.3335C9.99998 7.3335 8.66665 6.00016 8.66665 4.3335ZM4.33331 14.6668C5.99998 14.6668 7.33331 13.3335 7.33331 11.6668C7.33331 10.0002 5.99998 8.66683 4.33331 8.66683C2.66665 8.66683 1.33331 10.0002 1.33331 11.6668C1.33331 13.3335 2.66665 14.6668 4.33331 14.6668ZM11.6666 14.6668C13.3333 14.6668 14.6666 13.3335 14.6666 11.6668C14.6666 10.0002 13.3333 8.66683 11.6666 8.66683C9.99998 8.66683 8.66665 10.0002 8.66665 11.6668C8.66665 13.3335 9.99998 14.6668 11.6666 14.6668Z" fill="#00A1D3"/>
										</svg>
	                				</button>

	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary">
	                					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14 14.6668H1.99998C1.59998 14.6668 1.33331 14.4002 1.33331 14.0002C1.33331 13.6002 1.59998 13.3335 1.99998 13.3335H14C14.4 13.3335 14.6666 13.6002 14.6666 14.0002C14.6666 14.4002 14.4 14.6668 14 14.6668ZM8.66665 8.93351V2.00016C8.66665 1.60016 8.39998 1.3335 7.99998 1.3335C7.59998 1.3335 7.33331 1.60016 7.33331 2.00016V8.93351H8.66665Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M4.66669 8.93359H11.3334L8.46668 11.8003C8.20002 12.0669 7.80002 12.0669 7.53336 11.8003L4.66669 8.93359Z" fill="#00A1D3"/>
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


<script src="{{asset('assets/extends/js/pages/pengajuan-cuti.js')}}"></script>

<script>

</script>






@endsection
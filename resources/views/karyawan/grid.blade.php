@extends('layout.main')
@section('content')



<!--begin::Container-->
<div class="container">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8" style="background: #FFFFFF;box-shadow: 0px 0px 30px rgba(56, 71, 109, 0.1);border-radius: 12px;">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label text-dark font-weight-bolder" style="font-size:20px">Karyawan</span></br>
                <span class="text-muted" style="font-size:16px">Berikut merupakan data karyawan pada aplikasi KSI - ESS</span>
            </h3>
            <div class="card-toolbar">
               
            </div>
        </div>
        <div class="card-body pt-9 pb-0">
            <!--begin::Table--> 
            <div class="kt-portlet__body">
                <div id="table-wrapper">
                	{{--<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                		<thead>
	                		<tr class="font-weight-bolder text-center">
	                			<th scope="col">No</th>
	                			<th scope="col">NIP</th>
	                			<th scope="col">Username</th>
	                			<th scope="col">Nama</th>
	                			<th scope="col">Jabatan</th>
	                			<th scope="col">Action</th>
	                		</tr>
                		</thead>
                		<tbody>
	                		<tr>
	                			<td class="text-center">1</td>
	                			<td class="text-center">90238478723</td>
	                			<td class="text-center">salahuddin</td>
	                			<td>Salahuddin Al-ayyubi</td>
	                			<td class="text-center">Admin Keuangan</td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="resetPass()">
		                				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.66666 13.8175C9.73333 14.1508 9.46667 14.5508 9.13334 14.6175C8.80001 14.6841 8.4 14.6841 8.06667 14.6841C6.33333 14.6841 4.6 14.0174 3.33333 12.7508C0.933331 10.3508 0.733322 6.48411 2.86666 3.88411L3.80001 4.81746C2.20001 6.88413 2.39999 9.88413 4.26666 11.8175C5.46666 13.0175 7.19999 13.6175 8.93333 13.2841C9.26666 13.2175 9.6 13.4841 9.66666 13.8175ZM12.2667 11.2174L13.2 12.1508C15.2667 9.5508 15.1333 5.68412 12.6667 3.28412C11.1333 1.75078 8.99999 1.08412 6.86666 1.41746C6.53332 1.48412 6.26666 1.81746 6.33333 2.1508C6.4 2.48413 6.73334 2.75079 7.06667 2.68412C8.73334 2.41745 10.4667 2.9508 11.7333 4.1508C13.6667 6.1508 13.8 9.15078 12.2667 11.2174Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M1.33331 2.41748H4.66665C5.06665 2.41748 5.33331 2.68415 5.33331 3.08415V6.41746L1.33331 2.41748ZM10.6666 9.61749V12.9508C10.6666 13.3508 10.9333 13.6175 11.3333 13.6175H14.6666L10.6666 9.61749Z" fill="#00A1D3"/>
										</svg>
									</button>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td class="text-center">2</td>
	                			<td class="text-center">90238478723</td>
	                			<td class="text-center">john</td>
	                			<td>John F. Kenneddy</td>
	                			<td class="text-center">Staff Administrasi</td>
	                			<td class="text-center">
	                				<button class="btn btn-icon btn-color-primary btn-active-light-primary" onclick="resetPass()">
		                				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.66666 13.8175C9.73333 14.1508 9.46667 14.5508 9.13334 14.6175C8.80001 14.6841 8.4 14.6841 8.06667 14.6841C6.33333 14.6841 4.6 14.0174 3.33333 12.7508C0.933331 10.3508 0.733322 6.48411 2.86666 3.88411L3.80001 4.81746C2.20001 6.88413 2.39999 9.88413 4.26666 11.8175C5.46666 13.0175 7.19999 13.6175 8.93333 13.2841C9.26666 13.2175 9.6 13.4841 9.66666 13.8175ZM12.2667 11.2174L13.2 12.1508C15.2667 9.5508 15.1333 5.68412 12.6667 3.28412C11.1333 1.75078 8.99999 1.08412 6.86666 1.41746C6.53332 1.48412 6.26666 1.81746 6.33333 2.1508C6.4 2.48413 6.73334 2.75079 7.06667 2.68412C8.73334 2.41745 10.4667 2.9508 11.7333 4.1508C13.6667 6.1508 13.8 9.15078 12.2667 11.2174Z" fill="#00A1D3"/>
										<path opacity="0.3" d="M1.33331 2.41748H4.66665C5.06665 2.41748 5.33331 2.68415 5.33331 3.08415V6.41746L1.33331 2.41748ZM10.6666 9.61749V12.9508C10.6666 13.3508 10.9333 13.6175 11.3333 13.6175H14.6666L10.6666 9.61749Z" fill="#00A1D3"/>
										</svg>

									</button>
	                			</td>
	                		</tr>
	                	</tbody>
                	</table>--}}
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('assets/extends/js/pages/karyawan.js')}}"></script>

<script>



</script>






@endsection
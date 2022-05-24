
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../">
		<meta charset="utf-8" />
		<title>KSI - ESS</title>
		<meta name="description" content="PSU" />
		<meta name="keywords" content="PSU" />
		<link rel="canonical" href="{{asset('/')}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        @include('layout.css')
		<script>
			let baseUrl = "{{asset('/')}}";
			//let urlApi = "{{asset('/')}}api/";
    	</script>
	</head>
	<!--end::Head-->


	<style>

		.menu-title {
			color: #3f4254 !important;
		}

		.menu-title:hover {
			color: #00a1d3 !important;
		}
	</style>


	@include('layout.modal')

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:10px;--kt-toolbar-height-tablet-and-mobile:55px">
        <input type="hidden" value="{{env('URL_API')}}" id="api-url"/>
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Brand-->
					<div class="aside-logo flex-column-auto" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="javascript:;" class="text-center">
							<img class="d-inline" id="logo-1" src="{{ asset('assets/extends/img/ess-logo.png') }}">
							<img class="d-inline" id="logo-2" src="{{ asset('assets/extends/img/ksi-ess.png') }}" style="margin-left: 12px;">
							{{-- <svg width="88" height="14" viewBox="0 0 88 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7.442 13H11.204L6.128 6.556L11.024 0.364H7.406L3.194 5.908V0.364H0.116V13H3.194V7.42L7.442 13ZM23.1068 9.238C23.1068 5.008 16.8608 5.998 16.8608 3.802C16.8608 3.01 17.4188 2.632 18.1568 2.65C18.9848 2.668 19.5608 3.154 19.6148 3.964H22.9448C22.8188 1.552 20.9648 0.184 18.2108 0.184C15.5648 0.184 13.6028 1.516 13.6028 3.91C13.5668 8.392 19.8848 7.132 19.8848 9.472C19.8848 10.21 19.3088 10.66 18.4088 10.66C17.5448 10.66 16.9328 10.192 16.8428 9.22H13.5668C13.6568 11.776 15.7808 13.126 18.4988 13.126C21.4508 13.126 23.1068 11.362 23.1068 9.238ZM26.261 13H29.339V0.364H26.261V13ZM37.724 7.96H45.644V5.404H37.724V7.96ZM62.4199 0.364H54.6799V13H62.4199V10.534H57.7579V7.762H61.8799V5.386H57.7579V2.83H62.4199V0.364ZM74.8582 9.238C74.8582 5.008 68.6122 5.998 68.6122 3.802C68.6122 3.01 69.1702 2.632 69.9082 2.65C70.7362 2.668 71.3122 3.154 71.3662 3.964H74.6962C74.5702 1.552 72.7162 0.184 69.9622 0.184C67.3162 0.184 65.3542 1.516 65.3542 3.91C65.3182 8.392 71.6362 7.132 71.6362 9.472C71.6362 10.21 71.0602 10.66 70.1602 10.66C69.2962 10.66 68.6842 10.192 68.5942 9.22H65.3182C65.4082 11.776 67.5322 13.126 70.2502 13.126C73.2022 13.126 74.8582 11.362 74.8582 9.238ZM87.1924 9.238C87.1924 5.008 80.9464 5.998 80.9464 3.802C80.9464 3.01 81.5044 2.632 82.2424 2.65C83.0704 2.668 83.6464 3.154 83.7004 3.964H87.0304C86.9044 1.552 85.0504 0.184 82.2964 0.184C79.6504 0.184 77.6884 1.516 77.6884 3.91C77.6524 8.392 83.9704 7.132 83.9704 9.472C83.9704 10.21 83.3944 10.66 82.4944 10.66C81.6304 10.66 81.0184 10.192 80.9284 9.22H77.6524C77.7424 11.776 79.8664 13.126 82.5844 13.126C85.5364 13.126 87.1924 11.362 87.1924 9.238Z" fill="#00A1D3"/>
							</svg> --}}

						</a>
						<!--end::Logo-->
						<!--begin::Aside toggler-->
						<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
							<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-double-left.svg-->
							<span class="svg-icon svg-icon-1 rotate-180">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.5" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>

							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Aside toggler-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					@include('layout.menu')
					<!--end::Aside menu-->
					<!--begin::Footer-->
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" style="" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Aside mobile toggle-->
							<div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
								<div class="btn btn-icon btn-active-light-primary" id="kt_aside_mobile_toggle">
									<!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
									<span class="svg-icon svg-icon-2x mt-1">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
												<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
											</g>
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
							</div>
							<!--end::Aside mobile toggle-->
							<!--begin::Mobile logo-->
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<a href="index.html" class="d-lg-none">
									{{--<img alt="Logo" src="assets/media/logos/logo-3.svg" class="h-30px" />--}}
								</a>
							</div>
							<!--end::Mobile logo-->
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
								</div>
								<!--end::Navbar-->
								<!--begin::Topbar-->
								<div class="d-flex align-items-stretch flex-shrink-0">
									<!--begin::Toolbar wrapper-->
									<div class="d-flex align-items-stretch flex-shrink-0">


											<!--begin::User-->
										<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
											<!--begin::Menu wrapper-->
											<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
												<span>
													<span class="fs-11 text-dark-60 _nama_profile text-capitalize fw-bolder px-2 fs-5">-</span>
												</span>
												<span class="symbol symbol-35px ml-4" style="margin-left: 10px !important;">
													<span class="symbol-label fs-3 fw-bold text-primary _initial_profile">-</span>
												</span>
											</div>
											<!--begin::Menu-->
											<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<div class="menu-content d-flex align-items-center px-3">
														<!--begin::Avatar-->
														<div class="symbol symbol-50px me-5">
															{{-- <img src="" width="26" height="23" alt=""> --}}
															<span class="symbol-label fs-3 fw-bold text-primary _initial_profile">-</span>
														</div>
														<!--end::Avatar-->
														<!--begin::Username-->
														<div class="d-flex flex-column">
															<div id="xp-username" class="fw-bolder d-flex align-items-center fs-5 _nama_profile text-capitalize">-</div>
															<a id="xp-role" href="javascript:;" class="fw-bold text-muted text-hover-primary fs-7 _role_profile">-</a>
														</div>
														<!--end::Username-->
													</div>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu separator-->
												<div class="separator my-2"></div>
												<!--end::Menu separator-->
												<!--begin::Menu item-->
												<div class="menu-item px-5">
													<a href="javascript:;" onclick="openModalPassword()" class="navi-item ">
														<span class="menu-link text-hover-primary">
															<span class="menu-icon">
																<!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" clip-rule="evenodd" d="M6.09086 0.119141C8.65341 0.119141 10.8281 1.77241 11.6381 4.07913H21.7999V8.03916H19.8363V11.9991H15.909V8.03916H11.6381C10.8281 10.3458 8.65341 11.9991 6.09086 11.9991C2.83613 11.9991 0.199951 9.34099 0.199951 6.05914C0.199951 2.77729 2.83613 0.119141 6.09086 0.119141ZM4.12708 6.0586C4.12708 7.15259 5.00584 8.03862 6.09073 8.03862C7.17563 8.03862 8.05439 7.15263 8.05439 6.05865C8.05439 4.96467 7.17563 4.07864 6.09073 4.07864C5.00584 4.07864 4.12708 4.96462 4.12708 6.0586Z" fill="#888C9F"/>
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<span class="menu-title">Ubah Sandi</span>
														</span>
													</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<a href="javascript:;" onclick="logout()">
												<div class="menu-item px-5">
													<span class="menu-link text-hover-primary">
														<span class="menu-icon">
															<!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
															<span class="svg-icon svg-icon-2">
																<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M16.7818 4.93192L21.7999 10.0391L16.7818 15.1079V11.7095H9.27268V8.33032H16.7818V4.93192ZM13.7636 14.7623L15.6909 16.8167C13.8 18.6855 11.7515 19.6199 9.54541 19.6199C6.9151 19.6199 4.69995 18.7015 2.89995 16.8647C1.09995 15.0279 0.199951 12.7335 0.199951 9.98151C0.199951 8.25352 0.612072 6.65352 1.43631 5.18152C2.26056 3.70952 3.37268 2.54792 4.77268 1.69672C6.17268 0.845522 7.69086 0.419922 9.32722 0.419922C11.5575 0.419922 13.6727 1.36712 15.6727 3.26152L13.7636 5.29672C12.3818 3.96552 10.909 3.29992 9.34541 3.29992C7.53934 3.29992 6.0151 3.96552 4.77268 5.29672C3.53025 6.62792 2.90904 8.25352 2.90904 10.1735C2.90904 11.9655 3.54844 13.5079 4.82722 14.8007C6.10601 16.0935 7.60601 16.7399 9.32722 16.7399C10.9151 16.7399 12.3939 16.0807 13.7636 14.7623Z" fill="#888C9F"/>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
														<span class="menu-title">Keluar</span>
													</span>
												</div>
												</a>
												<!--end::Menu item-->
											</div>
											<!--end::Menu-->
											<!--end::Menu wrapper-->
										</div>
										<!--end::User -->



										<!--begin::Heaeder menu toggle-->
										<div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
											<div class="btn btn-icon btn-active-light-primary" id="kt_header_menu_mobile_toggle">
												<!--begin::Svg Icon | path: icons/duotone/Text/Toggle-Right.svg-->
												<span class="svg-icon svg-icon-1">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path fill-rule="evenodd" clip-rule="evenodd" d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z" fill="black" />
															<path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z" fill="black" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
										</div>
										<!--end::Heaeder menu toggle-->
									</div>
									<!--end::Toolbar wrapper-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							@include('layout.js')
                            <script>
                                var urlApi=$('#api-url').val()
                            </script>
							@yield('content')
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->



		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--end::Main-->


	</body>
	<!--end::Body-->
	<script>
		
        $(document).ready(function () {
            var roleID=localStorage.getItem("roleID")
            var nameProfile=localStorage.getItem("userName")
            var roleProfile=localStorage.getItem("roleName")
            var initials =""
			
			// if(roleID === '1') {
			// 	$("#xmn-master-parent").removeClass('d-none')
			// 	$("#xmn-setting").removeClass('d-none')
			// }
			
			
            if(nameProfile !== null) {
            	var splitName=nameProfile.split(" ")
	            
	            if(splitName.length>1){
	                initials = splitName.shift().charAt(0) + splitName.pop().charAt(0);
	            }else{
	                initials = splitName.shift().charAt(0)
	            }
            }
            else{
            	initials = " - "
            }
            
            $('._nama_profile').html(nameProfile)
            $('._initial_profile').html(initials.toUpperCase())
            $('._role_profile').html(roleProfile)
            
            // if(roleID=="2"||roleID=="4"){
            //     $('#div-master').addClass("d-none")
            //     $('#div-penilai').addClass("d-none")
            //     $('#div-periode').addClass("d-none")
            // }else if(roleID=="3"){
            //     $('#div-c-master .menu-item').addClass("d-none")
            //     $('#div-c-master #div-m-pegawai').removeClass("d-none")
            //     $('#div-penilai').addClass("d-none")
            //     $('#div-periode').addClass("d-none")
            // }
        })

        $('#btn-notif').on('click', function() {
        	grid_notif()
        })



	</script>
</html>